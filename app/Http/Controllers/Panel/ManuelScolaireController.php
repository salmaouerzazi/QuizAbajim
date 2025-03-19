<?php
namespace App\Http\Controllers\Panel;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\SectionMat;
use App\Models\School_level;
use App\Models\Document;
use App\Models\Card;
use App\Models\Subscribe;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CardReservation;
use App\Models\Video;
use App\Models\Material;
use App\Models\Like;
use App\Models\Manuels;
use App\Enfant;
use App\UserMatiere;
use App\Models\UserLevel;
use App\User;
use Carbon\Carbon;
use App\Models\Option;
use Illuminate\Support\Facades\Auth;
use Aws\S3\S3Client;
use Session;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use App\UserMinWatched;
use DB;
use App\Models\PaymentProof;

class ManuelScolaireController extends Controller
{
  public function resetDailyMinutes()
  {
      DB::transaction(function () {
          DB::table('user_min_watched')->update([
              'minutes_watched' => DB::raw('minutes_watched + minutes_watched_day'),
              'minutes_watched_day' => 0,
              'updated_at' => now(),
          ]);
      });
  }

  /**
   * Validate the card and activate the subscription.
   */
  public function validateCard(Request $request)
  {
    $cardNumber = preg_replace('/\s+/', '', $request->input('card_number'));
      $card = Card::where('card_key', $cardNumber)->first();
      $userLevel = auth()->user()->level_id;

      if (!$card) {
          return response()->json(['message' => 'لم يتم العثور على البطاقة.'], 404);
      }
  
      if ($card->is_used) {
          return response()->json(['message' => 'لقد تم استخدام البطاقة بالفعل.'], 400);
      }
      if ($card->level_id !== $userLevel) {
        return response()->json(['message' => 'مستوى البطاقة لا يتطابق مع مستواك.'], 403);
    }
    $expiresAt = Carbon::parse($card->created_at)->addMonths($card->expires_in ?? 9);

    if ($expiresAt->isPast()) {
        return response()->json(['message' => 'انتهت صلاحية البطاقة.'], 400);
    }
    $reservation = CardReservation::where('enfant_id', auth()->user()->id)->first();
    if ($reservation) {
        $reservation->status = 'approved';
        $reservation->save();       
    }

      $card->update([
          'status' => 'inactive',
          'is_used' => 1,
          'updated_at' => now(),
      ]);
      $order = Order::create([
        'user_id' => auth()->id(),
        'status' => 'paid',
        'amount' => $card->amount ?? 0,
        'tax' => 0,
        'total_discount' => 0,
        'total_amount' => $card->amount ?? 0,
        'reference_id' => $card->id,
        'created_at' => now()->timestamp,
    ]);
      $orderItem = OrderItem::create([
        'user_id' =>auth()->id(), 
        'order_id' =>  $order->id, 
        'model_type' => "App\Models\Subscribe",
        'model_id' => $card->subscribe_id,
        'amount' => $card->subscribe->price,
        'tax' => 0,
        'commission' => 0,
        'discount' => 0,
        'total_amount' => $card->subscribe->price,
        'created_at' => now()->timestamp,
    ]);   
    return response()->json([
        'message' => 'Card validated and subscription activated.Card validated and order created successfully.',
        'success' => true,
        'order' => $order,
    ]);
  }

  /**
   * Upload payment proof.
   */
  public function storePaymentProof(Request $request)
  {
      $request->validate([
        'proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'level_id' => 'required|exists:school_levels,id',
    ]);

    if ($request->hasFile('proof')) {
        $file = $request->file('proof');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('payment_proofs', $filename, 'public');

        $paymentProof = new PaymentProof();
        $paymentProof->user_id = Auth::id();
        $paymentProof->image = $path;
        $paymentProof->status = 'pending';
        $paymentProof->level_id = $request->level_id;
        $paymentProof->note = null;
        $paymentProof->approved_by = null;
        $paymentProof->save();

        $toastData = [
          'title' => trans('public.request_success'),
          'msg' => trans('panel.payment_proof_uploaded_successfully'),
          'status' => 'success'
          ];
          return redirect()->route('panel.dashboard.enfant')->with(['toast' => $toastData]);
          
    }
    $toastData = [
      'title' => trans('public.request_failed'),
      'msg' => trans('public.file_not_uploaded'),
      'status' => 'error'
    ];
    return redirect()->route('panel.dashboard.enfant')->with(['toast' => $toastData]);

    
  }

    public function downloadVideo($id)
    {
      $video = Video::findOrFail($id);
      $fileUrl = $video->video; 
      if (Storage::disk('s3')->exists($video->video)) {
        $url = Storage::disk('s3')->temporaryUrl(
            $video->video, now()->addMinutes(5)
        );
        return redirect()->to($url);
      }
      return redirect()->to($fileUrl);
    }

    public function unfollowTeacher($id)
    {
        $userId = auth()->id();
        $teacher = User::findOrFail($id);
    
        // Delete from `teachers` table
        DB::table('teachers')
            ->where('teacher_id', $id)
            ->where('users_id', $userId)
            ->delete();
    
        // Delete from `follows` table
        DB::table('follows')
            ->where('user_id', $userId)
            ->where('follower', $id)
            ->delete();
    
        // Get updated counts
        $newFollowerCount = DB::table('teachers')
            ->where('teacher_id', $id)
            ->count();
        $newFollowingCount = DB::table('teachers')
            ->where('users_id', $userId)
            ->count();
    
        return response()->json([
            'message' => __('panel.unfollow_success'),
            'isSubscribed' => false,
            'newFollowerCount' => $newFollowerCount,
            'newFollowingCount' => $newFollowingCount,
        ]);
    }
    

    public function deleteVideo($id)
    {
        $video = Video::find($id);
        if ($video) {
            $video->delete();
            $toastData = [
                'title' => trans('public.request_success'),
                'msg' => trans('panel.video_deleted_successfully'),
                'status' => 'success'
            ];
            return response()->json(['toast' => $toastData], 200);
        }
        $toastData = [
            'title' => trans('public.request_failed'),
            'msg' => trans('public.video_not_found'),
            'status' => 'error'
        ];
        return response()->json(['toast' => $toastData], 404);
    }

    public function check(Request $request)
      {
      $teacherId = $request->input('teacher_id');
      $userId = auth()->id(); 
      $isSubscribed = DB::table('teachers') 
                        ->where('teacher_id', $teacherId)
                        ->where('users_id', $userId)
                        ->exists();

      return response()->json(['isSubscribed' => $isSubscribed]);
      }
    
    public function like($id)
    {
      $video = Video::findOrFail($id);
      $user = Auth::user();

      $like = Like::where('user_id', $user->id)->where('video_id', $video->id)->first();

      if ($like) {
          $like->delete();
          $video->decrement('likes');
          $liked = false;
      } else {
          Like::create([
              'user_id' => $user->id,
              'video_id' => $video->id,
          ]);
          $video->increment('likes');
          $liked = true;
      }

      sendNotification('notification.new_like', 
      'notification.new_like_msg',
      $video->user_id,
      $user->id,
      'system',
      'single',
      ['user' => $user->full_name ,
      'title' => $video->titleAll
      ]
    );
      

      return response()->json(['likes' => $video->likes, 'liked' => $liked]);
    }

  public function upload(Request $request)
  {
      if ($request->hasFile('file')) {
          $file = $request->file('file');
          $filename = time() . '-' . $file->getClientOriginalName();
          $file->move(public_path('uploaded files'), $filename);
          return response()->json(['message' => 'File uploaded successfully', 'filename' => $filename]);
      }
      return response()->json(['message' => 'No file uploaded'], 400);
  }

  function convertMinutesToTime($totalMinutes) 
  {
    $minutes = floor($totalMinutes);
    $seconds = round(($totalMinutes - $minutes) * 60);
    return sprintf("%02d:%02d", $minutes, $seconds);
  }

  public function mychaine(Request $request)
  {
    $user = auth()->user();
    $sectionm = SectionMat::where('id', $user->section_id)->pluck('name');
    $matieretearcher = Material::where('id', $user->matier_id)->pluck('name');
    $optiontearcher = Option::where('id', $user->option_id)->pluck('name');
    $enfants = Enfant::where("parent_id", "=", auth()->user()->id)->orderBy("id", "desc")->with('level')->get();
    $userLevelIds = UserMatiere::where('teacher_id', $user->id)->pluck('level_id')->unique();
    $totalMinutesWatched = Video::where('user_id', $user->id)->sum('total_minutes_watched');
    $totalMinutesWatched = $this->convertMinutesToTime($totalMinutesWatched);
    $level = School_level::whereIn('id', $userLevelIds)->get();
    $manuelfiltre = Manuels::whereHas('matiere.section', function ($query) use ($userLevelIds) {
        $query->whereIn('level_id', $userLevelIds);
    })->pluck('name')->unique();

    $levelId = $request->get('level_id');

    $materialName = $request->get('material_name');
    $query = Video::where('user_id', $user->id)->orderBy('page', 'asc');

    if (!empty($levelId)) {
      
      $manuelfiltre = Manuels::whereHas('matiere.section', function ($query) use ($levelId) {
          $query->where('level_id', $levelId);
      })->pluck('name')->unique();
    }

    $totalViews = Video::where('user_id', $user->id)->withCount('viewers')->get()->sum('viewers_count');
    $video = $this->filterVideo($query, $request)->withCount('viewers')->paginate(12);
    $totalLikesCount = Video::where('user_id', $user->id)->sum('likes');
    $videocount = Video::where('user_id', $user->id)->count();
    $videostitleAll = Video::where('user_id', $user->id)->first();
      $userLevelIds = UserLevel::where('teacher_id', $user->id)->pluck('level_id');
      $listmatieree = UserMatiere::where('teacher_id', $user->id)->pluck('matiere_id');
      $matiereNames = [];
      foreach ($listmatieree as $matiereId) {
          $matiereName =  Material::where('id', $matiereId)->pluck('name')->first();        
          $matiereNames[] = $matiereName;
      }

    $data = [
      'pageTitle' => 'قناتي',
      'userLevelIds' => $userLevelIds,
      'matiereNames' => $matiereNames,
      'video' => $video,
      'videostitleAll' => $videostitleAll,
      'matieretearcher'  => $matieretearcher,
      'manuelfiltre'  => $manuelfiltre,
      'sectionm' => $sectionm,
      'level' => $level,
      'enfants' => $enfants,
      'optiontearcher' => $optiontearcher,
      'videocount' =>  $videocount,
      'totalViews' => $totalViews,
      'totalLikesCount' => $totalLikesCount,
      'totalMinutesWatched' => $totalMinutesWatched,
      'totalViews' => $totalViews,

    ];

    return view(getTemplate() . '.panel.Manuel_scolaire.index', $data);
  }


  public function filterVideo($query, $request)
  {
    
      $from = $request->get('from');
      $to = $request->get('to');
      $day = $request->get('day');
      $level_id = $request->get('level_id');
      $material_name = $request->get('material_name');
      $page_number= $request->get('page_number');
      $manuel_name = $request->get('manuel_name');
      if (!empty($material_name) && $material_name != 'all') {
          $query = $query->whereHas('manuel.matiere', function ($query) use ($material_name) {
              $query->where('name', $material_name);
          });
      }
      if (!empty($manuel_name) && $manuel_name != 'all') {
        $query = $query->whereHas('manuel', function ($query) use ($manuel_name) {
            $query->where('name', $manuel_name);
        });
    }
        if (!empty($level_id) and $level_id != 'all') {
            $query = $query->whereHas('manuel.matiere.section.level', function ($query) use ($level_id) {
                $query->where('id', $level_id);
            });
            
        }
        // page number 
        if (!empty($page_number) and $page_number != 'all') {
          $query = $query->where('page', $page_number);
      }

      return $query;
  }

  public function index()
  {
    $user = auth()->user();
    $sectionm = SectionMat::where('id', $user->section_id)->pluck('name');
    $matieretearcher = Material::where('id', $user->matier_id)->pluck('name');
    $optiontearcher = Option::where('id', $user->option_id)->pluck('name');
    $enfants = Enfant::where("parent_id", "=", auth()->user()->id)->orderBy("id", "desc")->with('level')->get();

    $levelm = School_level::where('id', $user->level_id)->pluck('name');
    $data = [

      'matieretearcher'  => $matieretearcher,
      'sectionm' => $sectionm,
      'levelm' => $levelm,
      'enfants' => $enfants,
      'optiontearcher' => $optiontearcher,

    ];
    return view(getTemplate() . '.panel.Manuel_scolaire.list', $data);
  }


  /**
   * Follow a teacher.
   * @param Request $request
   */

   public function add(Request $request)
   {
       $request->validate([
           'teacher_id' => 'required|exists:users,id',
       ]);
   
       $teacherId = $request->input('teacher_id');
       $userId = auth()->id();
       $user = auth()->user();
   
       $isAlreadySubscribed = DB::table('teachers')
           ->where('teacher_id', $teacherId)
           ->where('users_id', $userId)
           ->exists();
   
       if (!$isAlreadySubscribed) {
           DB::table('teachers')->insert([
               'teacher_id' => $teacherId,
               'users_id' => $userId,
               'created_at' => now(),
               'updated_at' => now(),
           ]);
           DB::table('follows')->insert([
               'user_id' => $userId,
               'follower' => $teacherId,
               'created_at' => now(),
               'updated_at' => now(),
           ]);
       } else {
           return response()->json([
               'isSubscribed' => true,
           ]);
       }
   
       // Send notification
       sendNotification('notification.new_follower',
           'notification.new_follower_msg',
           $teacherId, $userId, 'system', 'single', ['name' => $user->full_name]);
   
       // Get updated follower count
       $newFollowerCount = DB::table('teachers')
           ->where('teacher_id', $teacherId)
           ->count();
       $newFollowingCount = DB::table('teachers')
           ->where('users_id', $userId)
           ->count();
   
       return response()->json([
           'message' => 'Followed successfully',
           'isSubscribed' => true,
           'newFollowerCount' => $newFollowerCount,
           'newFollowingCount' => $newFollowingCount,
       ]);
   }
   
  /**
   * Unfollow a teacher.
   * @param Request $request
   */
  public function unadd(Request $request)
  {
    $userToUnsubscribe = User::findOrFail($request->input('trtr1'));
    $userToUnsubscribe->subscribers1()->detach(auth()->id());
    return redirect()->back();
  }
  /**
   * Store the teacher ID in the session.
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function storeTeacherId(Request $request)
  {  
      session(['teacher_id' => $request->input('teacher_id')]);
      return response()->json(['success' => true]);
  }

  /**
   * Check if the authenticated user is subscribed to the teacher.
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function checkSubscription(Request $request)
  {
      $user = Auth::user();
      $teacherId = $request->input('teacher_id');

      $isSubscribed = DB::table('teachers')
          ->where('teacher_id', $teacherId)
          ->where('users_id', $user->id)
          ->exists();

      $subscriptionCount = DB::table('teachers')
          ->where('teacher_id', $teacherId)
          ->count();

      return response()->json([
          'isSubscribed' => $isSubscribed,
          'subscriptionCount' => $subscriptionCount,
      ]);
  }

  public function addvideo(Request $request)
  {
      if ($request->hasFile('video')) {
          try {
              $video = $request->file('video');
              $filename = time() . '_' . $video->getClientOriginalName();
              $s3 = Storage::disk('s3');
              $path = $s3->putFileAs('videos', $video, $filename, 'public', [
                  'multipart' => true
              ]);
              $url = 'https://videos-abajim-1.s3.de.io.cloud.ovh.net/videos/' . $filename;
              $user = auth()->user();
              $videoRecord = Video::create([
                  'video' => $url,
                  'titleAll' => $video->getClientOriginalName(),
                  'page' => $request->page,
                  'numero' => $request->numero,
                  'manuel_id' => $request->manuel,
                  'user_id' => $user->id,
                  'status' => "APPROVED",
                  'created_at' => now(),
                  'updated_at' => now(),
              ]);
              $toastData = [
                  'title' => trans('public.request_success'),
                  'msg' => trans('panel.add_video_success'),
                  'status' => 'success',
              ];

              return response()->json([
                  'message' => trans('panel.add_video_success'),
                  'url' => $url,
                  'videoId' => $videoRecord->id,
                  'toast' => $toastData
              ], 200);

          } catch (\Exception $e) {
              $toastData = [
                  'title' => trans('public.request_failed'),
                  'msg' => trans('panel.add_video_failed'),
                  'status' => 'error',
              ];

              return response()->json([
                  'message' => 'Video upload failed',
                  'error' => $e->getMessage(),
                  'toast' => $toastData
              ], 500);
          }
      }
      return response()->json(['message' => 'No file uploaded'], 400);
  }
  public function getUserMinutes()
  {
      $user = auth()->user();
      $usermin = DB::table('user_min_watched')
          ->where('user_id', $user->id)
          ->pluck('minutes_watched_day')
          ->first();
  
      return response()->json(['minutes_watched' => $usermin ?? 0]);
  }

  /**
   * Update the watch time for videos of the authenticated user to know the total watch time.
   */
  public function updateWatchTime(Request $request)
  {
      $request->validate([
          'video_id' => 'required|integer',
          'minutes_watched' => 'required|numeric'
      ]);
      $video = Video::find($request->video_id);
      if (!$video) {
          return response()->json(['error' => 'Video not found.'], 404);
      }
      $video->increment('total_minutes_watched', $request->minutes_watched);
      return response()->json([
          'message' => 'Watch time updated successfully.',
          'total_minutes_watched' => $video->total_minutes_watched
      ]);
  }

  public function updateWatchTimeUser(Request $request)
{
    $request->validate([
        'minutes_watched' => 'required|numeric|min:0',
    ]);

    $user = auth()->user();
    $currentDateTimestamp = now()->startOfDay()->timestamp;
    $record = UserMinWatched::firstOrCreate(
        ['user_id' => $user->id],
        [
            'minutes_watched' => 0,
            'minutes_watched_day' => 0,
            'latest_watched_day' => $currentDateTimestamp,
        ]
    );

    if ($record->latest_watched_day !== $currentDateTimestamp) {
        $record->minutes_watched += $record->minutes_watched_day;
        $record->minutes_watched_day = 0;
        $record->latest_watched_day = $currentDateTimestamp;
        $record->save();
    }

    $newDailyMinutes = $record->minutes_watched_day + $request->minutes_watched;
    if ($newDailyMinutes >= 15) {
        $record->minutes_watched_day = 15;
        
        $record->save();

        return response()->json([
            'message' => 'Daily watch time limit exceeded.',
            'daily_minutes_watched' => 15,
        ], 403);
    }

    $record->increment('minutes_watched_day', $request->minutes_watched);

    return response()->json([
        'message' => 'Watch time updated successfully.',
        'total_minutes_watched' => $record->minutes_watched,
        'daily_minutes_watched' => $record->minutes_watched_day,
    ]);
}

  /**
   * Update the title of the video.
   */
  public function updateTitle(Request $request, $id)
    {
          $request->validate([
              'titleAll' => 'required|string|max:255',
          ]);
          $video = Video::findOrFail($id);
          $video->titleAll = $request->input('titleAll');
          $video->save();
          return redirect()->back()->with('success', 'Title updated successfully.');
    }

    /**
     * Delete the video.
     */
  public function destroy(Request $request, $id)
    {
      $user = auth()->user();

      $comment = Video::where('id', $id)
          ->where('user_id', $user->id)
          ->first();

      if (!empty($comment)) {
          $comment->delete();
      }

      return response()->json([
          'code' => 200
      ], 200);
    }
  
    /**
     * Mark the video as seen.
     */
  public function markAsSeen(Request $request)
  {
    $request->validate([
        'video_id' => 'required|exists:videos,id',
    ]);
    $videoId = $request->video_id;
    $user = auth()->user();
    $existingView = $user->viewedVideos()->where('video_id', $videoId)->first();
    if (!$existingView) {
        $user->viewedVideos()->attach($videoId);
        return response()->json(['message' => 'Video marked as seen']);
    }
    return response()->json(['message' => 'Video already seen'], 200);
  }

 public function addvideo1(Request $request)
{
  if ($request->hasFile('video')) {
      
    $video = $request->file('video');
    $filename = time() . '_' . $video->getClientOriginalName();
    $path = $video->move(public_path('videos'), $filename);
    $url =  'https://www.abajim.com/Abajim/public/videos/' . $filename;
        $user = auth()->user();
        Video::insert([
            'video' => $url,
            'page' => $request->page,
            'numero' => $request->numero,
            'manuel_id' =>  $request->manuel,
            'user_id' =>   $user->id,
            'status' => "APPROVED",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $toastData = [
          'title' => trans('public.request_success'),
          'msg' => trans('site.become_instructor_success_request'),
          'status' => 'success'
      ];
  
        return response()->json(['toast' =>$toastData, 'path' =>  $path ], 200);
    }
    
    return response()->json(['message' => 'No file uploaded'], 400);
}

  /**
   * list_free_parser
   */
  public function methode($id)
  {
        $user = auth()->user();
        $sectionm = SectionMat::where('id', $user->section_id)->pluck('name');
        $levelm = School_level::where('id', $user->level_id)->pluck('name');
        $math = Material::where('section_id', $user->section_id)->first();
        $optiontearcher = Option::where('id', $user->option_id)->pluck('name');
        $enfants = Enfant::where("parent_id", "=", auth()->user()->id)->orderBy("id", "desc")->with('level')->get();

        $listmatieree = UserMatiere::where('teacher_id', $user->id)->pluck('matiere_id');
        $matiereNames = []; // Array to store the names of materials
        foreach ($listmatieree as $matiereId) {
          $matiereName = Material::where('id', $matiereId)->pluck('name')->first(); // Assuming 'name' is the field you want
          if (!is_null($matiereName)) { // Check if matiereName is not null
              $matiereNames[] = $matiereName;
          }
        }

        $matiere = Material::where('section_id', $user->section_id)->pluck('name');
        $matiereid = Material::where('section_id', $user->section_id)->where('id','!=',7)->where('id','!=',11)->where('id','!=',14)->where('id','!=',15)->where('id','!=',18)->where('id','!=',19)->where('id','!=',20)->where('id','!=',21)->where('id','!=',23)->pluck('id');

        $Manuels = Manuels::whereIn('material_id', $matiereid)->where('id','!=',14)->where('id','!=',24)->where('id','!=',34)->where('id','!=',27)->where('id','!=',9)->where('id','!=',1313)
        ->with([
            'matiere' => function ($query) { 
                $query->with(['section' => function ($query) {
                    $query->with('level');
                }]);
            }
        ])->get();

        $t3DPathManuels= Document::where('manuel_id', $id)->pluck('3d_path_enfant');
        $teacherId = Session::get('teacher_id');
        $page = request('page');
        $icon = request('icon');
        $videoQuery = Video::where('manuel_id', $id)
        ->where('numero', $icon)
        ->where('page', $page)
        ->with(['likes', 'teachers']);

        if ($teacherId) {
            $videoQuery->where('user_id', $teacherId);
        }
        
        $videos = $videoQuery->get();
        $videostitleAll = $videos->first();
        $isSubscribed = false;
        $subscriptions = [];


        foreach ($videos as $video) {
          $teacherId = $video->teachers->id;
          $isSubscribedForTeacher = DB::table('teachers')
              ->where('users_id', $user->id)
              ->where('teacher_id', $teacherId)
              ->exists();
      
          $subscriptions[$teacherId] = $isSubscribedForTeacher;
      
          if ($video === $videos->first()) {
              $isSubscribed = $isSubscribedForTeacher;
          }
      }
        $Manuelsname = Manuels::where('id', $id)->pluck('name');
        $documents = Document::where('manuel_id', $id)->pluck('pdf');
        $pdfFilePath2 = env('APP_ENV_URL').$documents[0];
        $pdfFilePath = env('APP_ENV_URL').'/'.$documents[0];
        $pdfFilePath1 = public_path($documents[0]) ;
        
        if ($documents[0] == '1_ereF/riadhiat_oula.pdf') {
        
            $icon1FilePath = 'https://abajim.com/pdf/play-button.png';
    
            $icon1_1X = 154;
            $icon1_1Y = 59;
            $icon1_1Width = 10;
            $icon1_1Height = 10;
    
            $icon1_2X = 153;
            $icon1_2Y = 187;
            $icon1_2Width = 10;
            $icon1_2Height = 10;
    
            $icon2_1X = 155;
            $icon2_1Y = 25;
            $icon2_1Width = 10;
            $icon2_1Height = 10;
    
            $icon2_2X = 157;
            $icon2_2Y = 196;
            $icon2_2Width = 10;
            $icon2_2Height = 10;
    
            $icon3_1X = 154;
            $icon3_1Y = 58;
            $icon3_1Width = 10;
            $icon3_1Height = 10;
    
            $icon3_2X = 153;
            $icon3_2Y = 192;
            $icon3_2Width = 10;
            $icon3_2Height = 10;
    
            $icon4_1X = 154;
            $icon4_1Y = 30;
            $icon4_1Width = 10;
            $icon4_1Height = 10;
    
            $icon4_2X = 156;
            $icon4_2Y = 162;
            $icon4_2Width = 10;
            $icon4_2Height = 10;
    
            $icon5_1X = 155;
            $icon5_1Y = 60;
            $icon5_1Width = 10;
            $icon5_1Height = 10;
    
            $icon5_2X = 153;
            $icon5_2Y = 156;
            $icon5_2Width = 10;
            $icon5_2Height = 10;
    
            $icon6_1X = 154;
            $icon6_1Y = 89;
            $icon6_1Width = 10;
            $icon6_1Height = 10;
    
            $icon6_2X = 157;
            $icon6_2Y = 182;
            $icon6_2Width = 10;
            $icon6_2Height = 10;
    
            $icon7X = 154;
            $icon7Y = 61;
            $icon7Width = 10;
            $icon7Height = 10;
    
            $icon8X = 155;
            $icon8Y = 29;
            $icon8Width = 10;
            $icon8Height = 10;
    
            $icon9_1X = 154;
            $icon9_1Y = 29;
            $icon9_1Width = 10;
            $icon9_1Height = 10;
    
            $icon9_2X = 157;
            $icon9_2Y = 169;
            $icon9_2Width = 10;
            $icon9_2Height = 10;
    
            $icon10_1X = 154;
            $icon10_1Y = 58;
            $icon10_1Width = 10;
            $icon10_1Height = 10;
    
            $icon10_2X = 153;
            $icon10_2Y = 183;
            $icon10_2Width = 10;
            $icon10_2Height = 10;
    
            $icon11_1X = 154;
            $icon11_1Y = 29;
            $icon11_1Width = 10;
            $icon11_1Height = 10;
    
            $icon11_2X = 154;
            $icon11_2Y = 187;
            $icon11_2Width = 10;
            $icon11_2Height = 10;
    
            $icon12_1X = 154;
            $icon12_1Y = 57;
            $icon12_1Width = 10;
            $icon12_1Height = 10;
    
            $icon12_2X = 153;
            $icon12_2Y = 165;
            $icon12_2Width = 10;
            $icon12_2Height = 10;
    
            $icon13_1X = 154;
            $icon13_1Y = 31;
            $icon13_1Width = 10;
            $icon13_1Height = 10;
    
            $icon13_2X = 157;
            $icon13_2Y = 174;
            $icon13_2Width = 10;
            $icon13_2Height = 10;
    
            $icon14_1X = 153;
            $icon14_1Y = 60;
            $icon14_1Width = 10;
            $icon14_1Height = 10;
    
            $icon14_2X = 153;
            $icon14_2Y = 175;
            $icon14_2Width = 10;
            $icon14_2Height = 10;
    
            $icon15X = 152;
            $icon15Y = 142;
            $icon15Width = 10;
            $icon15Height = 10;
    
            $icon16X = 156;
            $icon16Y = 29;
            $icon16Width = 10;
            $icon16Height = 10;
    
            $icon17_1X = 153;
            $icon17_1Y = 58;
            $icon17_1Width = 10;
            $icon17_1Height = 10;
    
            $icon17_2X = 153;
            $icon17_2Y = 153;
            $icon17_2Width = 10;
            $icon17_2Height = 10;
    
            $icon18X = 154;
            $icon18Y = 172;
            $icon18Width = 10;
            $icon18Height = 10;
    
            $icon19X = 155;
            $icon19Y = 124;
            $icon19Width = 10;
            $icon19Height = 10;
    
            $icon20_1X = 152;
            $icon20_1Y = 61;
            $icon20_1Width = 10;
            $icon20_1Height = 10;
    
            $icon20_2X = 153;
            $icon20_2Y = 159;
            $icon20_2Width = 10;
            $icon20_2Height = 10;
    
            $icon21X = 154;
            $icon21Y = 183;
            $icon21Width = 10;
            $icon21Height = 10;
    
            $icon22X = 155;
            $icon22Y = 131;
            $icon22Width = 10;
            $icon22Height = 10;
    
            $icon23_1X = 153;
            $icon23_1Y = 62;
            $icon23_1Width = 10;
            $icon23_1Height = 10;
    
            $icon23_2X = 153;
            $icon23_2Y = 171;
            $icon23_2Width = 10;
            $icon23_2Height = 10;
    
            $icon24X = 154;
            $icon24Y = 170;
            $icon24Width = 10;
            $icon24Height = 10;
    
            $icon25X = 156;
            $icon25Y = 32;
            $icon25Width = 10;
            $icon25Height = 10;
    
            $icon26_1X = 32;
            $icon26_1Y = 59;
            $icon26_1Width = 10;
            $icon26_1Height = 10;
    
            $icon26_2X = 153;
            $icon26_2Y = 155;
            $icon26_2Width = 10;
            $icon26_2Height = 10;
    
            $icon27_1X = 154;
            $icon27_1Y = 106;
            $icon27_1Width = 10;
            $icon27_1Height = 10;
    
            $icon27_2X = 155;
            $icon27_2Y = 189;
            $icon27_2Width = 10;
            $icon27_2Height = 10;
    
            $icon28_1X = 155;
            $icon28_1Y = 59;
            $icon28_1Width = 10;
            $icon28_1Height = 10;
    
            $icon28_2X = 152;
            $icon28_2Y = 198;
            $icon28_2Width = 10;
            $icon28_2Height = 10;
    
            $icon29_1X = 154;
            $icon29_1Y = 32;
            $icon29_1Width = 10;
            $icon29_1Height = 10;
    
            $icon29_2X = 155;
            $icon29_2Y = 174;
            $icon29_2Width = 10;
            $icon29_2Height = 10;
    
            $icon30X = 154;
            $icon30Y = 58;
            $icon30Width = 10;
            $icon30Height = 10;
    
            $icon31X = 154;
            $icon31Y = 29;
            $icon31Width = 10;
            $icon31Height = 10;
    
            $icon32X = 154;
            $icon32Y = 183;
            $icon32Width = 10;
            $icon32Height = 10;
    
            $icon33X = 155;
            $icon33Y = 32;
            $icon33Width = 10;
            $icon33Height = 10;
    
            $icon34_1X = 158;
            $icon34_1Y = 58;
            $icon34_1Width = 8;
            $icon34_1Height = 8;
    
            $icon34_2X = 153;
            $icon34_2Y = 164;
            $icon34_2Width = 10;
            $icon34_2Height = 10;
    
            $icon35_1X = 154;
            $icon35_1Y = 31;
            $icon35_1Width = 10;
            $icon35_1Height = 10;
    
            $icon35_2X = 155;
            $icon35_2Y = 193;
            $icon35_2Width = 10;
            $icon35_2Height = 10;
    
            $icon36X = 158;
            $icon36Y = 59;
            $icon36Width = 8;
            $icon36Height = 8;
    
            $icon37X = 154;
            $icon37Y = 31;
            $icon37Width = 10;
            $icon37Height = 10;
    
            $icon38X = 154;
            $icon38Y = 134;
            $icon38Width = 10;
            $icon38Height = 10;
    
            $icon39X = 155;
            $icon39Y = 33;
            $icon39Width = 10;
            $icon39Height = 10;
    
            $icon40X = 155;
            $icon40Y = 59;
            $icon40Width = 10;
            $icon40Height = 10;
    
            $icon41X = 154;
            $icon41Y = 31;
            $icon41Width = 10;
            $icon41Height = 10;
    
            $icon42_1X = 154;
            $icon42_1Y = 31;
            $icon42_1Width = 10;
            $icon42_1Height = 10;
    
            $icon42_2X = 155;
            $icon42_2Y = 147;
            $icon42_2Width = 10;
            $icon42_2Height = 10;
    
            $icon43_1X = 155;
            $icon43_1Y = 54;
            $icon43_1Width = 10;
            $icon43_1Height = 10;
    
            $icon43_2X = 153;
            $icon43_2Y = 182;
            $icon43_2Width = 10;
            $icon43_2Height = 10;
    
            $icon44_1X = 154;
            $icon44_1Y = 101;
            $icon44_1Width = 10;
            $icon44_1Height = 10;
    
            $icon44_2X = 155;
            $icon44_2Y = 198;
            $icon44_2Width = 10;
            $icon44_2Height = 10;
    
            $icon45X = 153;
            $icon45Y = 66;
            $icon45Width = 10;
            $icon45Height = 10;
    
            $icon46X = 154;
            $icon46Y = 31;
            $icon46Width = 10;
            $icon46Height = 10;
    
            $icon47_1X = 154;
            $icon47_1Y = 31;
            $icon47_1Width = 10;
            $icon47_1Height = 10;
    
            $icon47_2X = 155;
            $icon47_2Y = 141;
            $icon47_2Width = 10;
            $icon47_2Height = 10;
    
            $icon48X = 21;
            $icon48Y = 67;
            $icon48Width = 10;
            $icon48Height = 10;
    
            $icon49X = 153;
            $icon49Y = 31;
            $icon49Width = 10;
            $icon49Height = 10;
    
            $icon50_1X = 153;
            $icon50_1Y = 29;
            $icon50_1Width = 10;
            $icon50_1Height = 10;
    
            $icon50_2X = 155;
            $icon50_2Y = 153;
            $icon50_2Width = 10;
            $icon50_2Height = 10;
    
            $icon51X = 153;
            $icon51Y = 72;
            $icon51Width = 10;
            $icon51Height = 10;
    
            $icon52X = 154;
            $icon52Y = 31;
            $icon52Width = 10;
            $icon52Height = 10;
    
            $icon53_1X = 154;
            $icon53_1Y = 30;
            $icon53_1Width = 10;
            $icon53_1Height = 10;
    
            $icon53_2X = 155;
            $icon53_2Y = 192;
            $icon53_2Width = 10;
            $icon53_2Height = 10;
    
            $icon54_1X = 119;
            $icon54_1Y = 63;
            $icon54_1Width = 10;
            $icon54_1Height = 10;
    
            $icon54_2X = 153;
            $icon54_2Y = 158;
            $icon54_2Width = 10;
            $icon54_2Height = 10;
    
            $icon55_1X = 154;
            $icon55_1Y = 31;
            $icon55_1Width = 10;
            $icon55_1Height = 10;
    
            $icon55_2X = 155;
            $icon55_2Y = 179;
            $icon55_2Width = 10;
            $icon55_2Height = 10;
    
            $icon56X = 153;
            $icon56Y = 77;
            $icon56Width = 10;
            $icon56Height = 10;
    
            $icon57X = 153;
            $icon57Y = 27;
            $icon57Width = 10;
            $icon57Height = 10;
    
            $icon58X = 155;
            $icon58Y = 99;
            $icon58Width = 10;
            $icon58Height = 10;
    
            $icon59_1X = 154;
            $icon59_1Y = 65;
            $icon59_1Width = 10;
            $icon59_1Height = 10;
    
            $icon59_2X = 153;
            $icon59_2Y = 164;
            $icon59_2Width = 10;
            $icon59_2Height = 10;
    
            $icon60_1X = 154;
            $icon60_1Y = 81;
            $icon60_1Width = 10;
            $icon60_1Height = 10;
    
            $icon60_2X = 155;
            $icon60_2Y = 165;
            $icon60_2Width = 10;
            $icon60_2Height = 10;
    
            $icon61_1X = 154;
            $icon61_1Y = 64;
            $icon61_1Width = 10;
            $icon61_1Height = 10;
    
            $icon61_2X = 153;
            $icon61_2Y = 155;
            $icon61_2Width = 10;
            $icon61_2Height = 10;
    
            $icon62_1X = 153;
            $icon62_1Y = 87;
            $icon62_1Width = 10;
            $icon62_1Height = 10;
    
            $icon62_2X = 155;
            $icon62_2Y = 213;
            $icon62_2Width = 10;
            $icon62_2Height = 10;
    
            $icon63_1X = 153;
            $icon63_1Y = 59;
            $icon63_1Width = 10;
            $icon63_1Height = 10;
    
            $icon63_2X = 153;
            $icon63_2Y = 189;
            $icon63_2Width = 10;
            $icon63_2Height = 10;
    
            $icon64_1X = 153;
            $icon64_1Y = 77;
            $icon64_1Width = 10;
            $icon64_1Height = 10;
    
            $icon64_2X = 155;
            $icon64_2Y = 160;
            $icon64_2Width = 10;
            $icon64_2Height = 10;
    
            $icon65_1X = 153;
            $icon65_1Y = 62;
            $icon65_1Width = 10;
            $icon65_1Height = 10;
    
            $icon65_2X = 152;
            $icon65_2Y = 199;
            $icon65_2Width = 10;
            $icon65_2Height = 10;
    
            $icon66_1X = 153;
            $icon66_1Y = 113;
            $icon66_1Width = 10;
            $icon66_1Height = 10;
    
            $icon66_2X = 155;
            $icon66_2Y = 192;
            $icon66_2Width = 10;
            $icon66_2Height = 10;
    
            $icon67_1X = 153;
            $icon67_1Y = 77;
            $icon67_1Width = 10;
            $icon67_1Height = 10;
    
            $icon67_2X = 151;
            $icon67_2Y = 171;
            $icon67_2Width = 10;
            $icon67_2Height = 10;
    
            $icon68_1X = 153;
            $icon68_1Y = 75;
            $icon68_1Width = 10;
            $icon68_1Height = 10;
    
            $icon68_2X = 155;
            $icon68_2Y = 205;
            $icon68_2Width = 10;
            $icon68_2Height = 10;
    
            $icon69_1X = 44;
            $icon69_1Y = 79;
            $icon69_1Width = 10;
            $icon69_1Height = 10;
    
            $icon69_2X = 152;
            $icon69_2Y = 204;
            $icon69_2Width = 10;
            $icon69_2Height = 10;
    
            $icon70_1X = 153;
            $icon70_1Y = 113;
            $icon70_1Width = 10;
            $icon70_1Height = 10;
    
            $icon70_2X = 155;
            $icon70_2Y = 197;
            $icon70_2Width = 10;
            $icon70_2Height = 10;
    
            $icon80X = 153;
            $icon80Y = 68;
            $icon80Width = 10;
            $icon80Height = 10;
    
            $icon81_1X = 152;
            $icon81_1Y = 33;
            $icon81_1Width = 10;
            $icon81_1Height = 10;
    
            $icon81_2X = 153;
            $icon81_2Y = 172;
            $icon81_2Width = 10;
            $icon81_2Height = 10;
    
            $icon82X = 155;
            $icon82Y = 79;
            $icon82Width = 10;
            $icon82Height = 10;
    
            $icon83_1X = 153;
            $icon83_1Y = 76;
            $icon83_1Width = 10;
            $icon83_1Height = 10;
    
            $icon83_2X = 152;
            $icon83_2Y = 190;
            $icon83_2Width = 10;
            $icon83_2Height = 10;
    
            $icon84_1X = 153;
            $icon84_1Y = 110;
            $icon84_1Width = 10;
            $icon84_1Height = 10;
    
            $icon84_2X = 155;
            $icon84_2Y = 195;
            $icon84_2Width = 10;
            $icon84_2Height = 10;
    
            $icon85_1X = 153;
            $icon85_1Y = 67;
            $icon85_1Width = 10;
            $icon85_1Height = 10;
    
            $icon85_2X = 153;
            $icon85_2Y = 201;
            $icon85_2Width = 10;
            $icon85_2Height = 10;
    
            $icon86_1X = 153;
            $icon86_1Y = 76;
            $icon86_1Width = 10;
            $icon86_1Height = 10;
    
            $icon86_2X = 155;
            $icon86_2Y = 180;
            $icon86_2Width = 10;
            $icon86_2Height = 10;
    
            $icon87_1X = 153;
            $icon87_1Y = 63;
            $icon87_1Width = 10;
            $icon87_1Height = 10;
    
            $icon87_2X = 152;
            $icon87_2Y = 207;
            $icon87_2Width = 10;
            $icon87_2Height = 10;
    
            $icon88_1X = 153;
            $icon88_1Y = 78;
            $icon88_1Width = 10;
            $icon88_1Height = 10;
    
            $icon88_2X = 155;
            $icon88_2Y = 203;
            $icon88_2Width = 10;
            $icon88_2Height = 10;
    
            $icon89_1X = 158;
            $icon89_1Y = 71;
            $icon89_1Width = 7;
            $icon89_1Height = 8;
    
            $icon89_2X = 152;
            $icon89_2Y = 207;
            $icon89_2Width = 10;
            $icon89_2Height = 10;
    
            $icon90X = 153;
            $icon90Y = 110;
            $icon90Width = 10;
            $icon90Height = 10;
    
            $icon91X = 155;
            $icon91Y = 34;
            $icon91Width = 10;
            $icon91Height = 10;
    
            $icon92_1X = 153;
            $icon92_1Y = 59;
            $icon92_1Width = 10;
            $icon92_1Height = 10;
    
            $icon92_2X = 152;
            $icon92_2Y = 183;
            $icon92_2Width = 10;
            $icon92_2Height = 10;
    
            $icon93_1X = 153;
            $icon93_1Y = 110;
            $icon93_1Width = 10;
            $icon93_1Height = 10;
    
            $icon93_2X = 155;
            $icon93_2Y = 214;
            $icon93_2Width = 10;
            $icon93_2Height = 10;
    
            $icon94_1X = 153;
            $icon94_1Y = 79;
            $icon94_1Width = 10;
            $icon94_1Height = 10;
    
            $icon94_2X = 152;
            $icon94_2Y = 194;
            $icon94_2Width = 10;
            $icon94_2Height = 10;
    
            $icon95X = 153;
            $icon95Y = 190;
            $icon95Width = 10;
            $icon95Height = 10;
    
            $icon96X = 155;
            $icon96Y = 98;
            $icon96Width = 10;
            $icon96Height = 10;
    
            $icon97_1X = 155;
            $icon97_1Y = 70;
            $icon97_1Width = 8;
            $icon97_1Height = 8;
    
            $icon97_2X = 152;
            $icon97_2Y = 204;
            $icon97_2Width = 10;
            $icon97_2Height = 10;
    
            $icon98_1X = 153;
            $icon98_1Y = 34;
            $icon98_1Width = 10;
            $icon98_1Height = 10;
    
            $icon98_2X = 155;
            $icon98_2Y = 137;
            $icon98_2Width = 10;
            $icon98_2Height = 10;
    
            $icon99X = 153;
            $icon99Y = 72;
            $icon99Width = 10;
            $icon99Height = 10;
    
            $icon100_1X = 151;
            $icon100_1Y = 34;
            $icon100_1Width = 10;
            $icon100_1Height = 10;
    
            $icon100_2X = 152;
            $icon100_2Y = 204;
            $icon100_2Width = 10;
            $icon100_2Height = 10;
    
            $icon101X = 155;
            $icon101Y = 34;
            $icon101Width = 10;
            $icon101Height = 10;
    
            $icon102_1X = 154;
            $icon102_1Y = 59;
            $icon102_1Width = 10;
            $icon102_1Height = 10;
    
            $icon102_2X = 152;
            $icon102_2Y = 172;
            $icon102_2Width = 10;
            $icon102_2Height = 10;
    
            $icon103_1X = 153;
            $icon103_1Y = 88;
            $icon103_1Width = 10;
            $icon103_1Height = 10;
    
            $icon103_2X = 155;
            $icon103_2Y = 185;
            $icon103_2Width = 10;
            $icon103_2Height = 10;
    
            $icon104_1X = 17;
            $icon104_1Y = 61;
            $icon104_1Width = 10;
            $icon104_1Height = 10;
    
            $icon104_2X = 152;
            $icon104_2Y = 181;
            $icon104_2Width = 10;
            $icon104_2Height = 10;
    
            $icon105_1X = 153;
            $icon105_1Y = 106;
            $icon105_1Width = 10;
            $icon105_1Height = 10;
    
            $icon105_2X = 155;
            $icon105_2Y = 196;
            $icon105_2Width = 10;
            $icon105_2Height = 10;
    
            $icon106_1X = 153;
            $icon106_1Y = 68;
            $icon106_1Width = 10;
            $icon106_1Height = 10;
    
            $icon106_2X = 153;
            $icon106_2Y = 196;
            $icon106_2Width = 10;
            $icon106_2Height = 10;
    
            $icon107_1X = 153;
            $icon107_1Y = 108;
            $icon107_1Width = 10;
            $icon107_1Height = 10;
    
            $icon107_2X = 155;
            $icon107_2Y = 205;
            $icon107_2Width = 10;
            $icon107_2Height = 10;
    
            $icon108_1X = 153;
            $icon108_1Y = 67;
            $icon108_1Width = 10;
            $icon108_1Height = 10;
    
            $icon108_2X = 152;
            $icon108_2Y = 199;
            $icon108_2Width = 10;
            $icon108_2Height = 10;
    
            $icon109_1X = 153;
            $icon109_1Y = 87;
            $icon109_1Width = 10;
            $icon109_1Height = 10;
    
            $icon109_2X = 155;
            $icon109_2Y = 199;
            $icon109_2Width = 10;
            $icon109_2Height = 10;
    
            $icon110X = 153;
            $icon110Y = 67;
            $icon110Width = 10;
            $icon110Height = 10;
    
            $icon111X = 152;
            $icon111Y = 33;
            $icon111Width = 10;
            $icon111Height = 10;
    
            $icon112X = 153;
            $icon112Y = 125;
            $icon112Width = 10;
            $icon112Height = 10;
    
            $icon113X = 155;
            $icon113Y = 34;
            $icon113Width = 10;
            $icon113Height = 10;
            
            $icon114_1X = 155;
            $icon114_1Y = 76;
            $icon114_1Width = 10;
            $icon114_1Height = 10;
    
            $icon114_2X = 152;
            $icon114_2Y = 158;
            $icon114_2Width = 10;
            $icon114_2Height = 10;
    
            $icon115X = 153;
            $icon115Y = 84;
            $icon115Width = 10;
            $icon115Height = 10;
    
            $icon116X = 155;
            $icon116Y = 34;
            $icon116Width = 10;
            $icon116Height = 10;
    
            $icon117_1X = 153;
            $icon117_1Y = 64;
            $icon117_1Width = 10;
            $icon117_1Height = 10;
    
            $icon117_2X = 152;
            $icon117_2Y = 195;
            $icon117_2Width = 10;
            $icon117_2Height = 10;
    
            $icon118_1X = 153;
            $icon118_1Y = 33;
            $icon118_1Width = 10;
            $icon118_1Height = 10;
    
            $icon118_2X = 155;
            $icon118_2Y = 156;
            $icon118_2Width = 10;
            $icon118_2Height = 10;
    
    
              // Define the link URLs
              $linkUrlBase = url('/panel/scolaire', ['id' => $id]);
    
              $iconUrlParam = '?icon=';
              $pageUrlParam = '&page=';
              $teacherUrlParam = '&teacher_id=' . $teacherId; // Append teacher_id in the URL


              $icon1Message = 'Ceci est le message de l\'icône 1';
              // Create a new instance of FPDI
                  // Create a new instance of FPDI
              $pdf = new Fpdi();
    
            
              $pageCount = $pdf->setSourceFile($pdfFilePath1);
              

                   
            for ($pageNo = 1; $pageNo <= 4 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
            }
            for ($pageNo = 5; $pageNo <= 5 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 1_1;
              $pdf->Image($icon1FilePath, $icon1_1X, $icon1_1Y, $icon1_1Width, $icon1_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo . $teacherUrlParam;
              $pdf->Link($icon1_1X, $icon1_1Y, $icon1_1Width, $icon1_1Height, $linkUrl);
              $iconNo = 1_2;
              $pdf->Image($icon1FilePath, $icon1_2X, $icon1_2Y, $icon1_2Width, $icon1_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo . $teacherUrlParam;
              $pdf->Link($icon1_2X, $icon1_2Y, $icon1_2Width, $icon1_2Height, $linkUrl);
            }
            for ($pageNo = 6; $pageNo <= 6 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
            }

            for ($pageNo = 7; $pageNo <= 7 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 2_1;
              $pdf->Image($icon1FilePath, $icon2_1X, $icon2_1Y, $icon2_1Width, $icon2_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon2_1X, $icon2_1Y, $icon2_1Width, $icon2_1Height, $linkUrl);
              $iconNo = 2_2;
              $pdf->Image($icon1FilePath, $icon2_2X, $icon2_2Y, $icon2_2Width, $icon2_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon2_2X, $icon2_2Y, $icon2_2Width, $icon2_2Height, $linkUrl);
            }
            for ($pageNo = 8; $pageNo <= 8 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 3_1;
              $pdf->Image($icon1FilePath, $icon3_1X, $icon3_1Y, $icon3_1Width, $icon3_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon3_1X, $icon3_1Y, $icon3_1Width, $icon3_1Height, $linkUrl);
              $iconNo = 3_2;
              $pdf->Image($icon1FilePath, $icon3_2X, $icon3_2Y, $icon3_2Width, $icon3_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon3_2X, $icon3_2Y, $icon3_2Width, $icon3_2Height, $linkUrl);
            }
            for ($pageNo = 9; $pageNo <= 9 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 4_1;
              $pdf->Image($icon1FilePath, $icon4_1X, $icon4_1Y, $icon4_1Width, $icon4_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon4_1X, $icon4_1Y, $icon4_1Width, $icon4_1Height, $linkUrl);
              $iconNo = 4_2;
              $pdf->Image($icon1FilePath, $icon4_2X, $icon4_2Y, $icon4_2Width, $icon4_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon4_2X, $icon4_2Y, $icon4_2Width, $icon4_2Height, $linkUrl);
            }
            for ($pageNo = 10; $pageNo <= 10 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 5_1;
              $pdf->Image($icon1FilePath, $icon5_1X, $icon5_1Y, $icon5_1Width, $icon5_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon5_1X, $icon5_1Y, $icon5_1Width, $icon5_1Height, $linkUrl);
              $iconNo = 5_2;
              $pdf->Image($icon1FilePath, $icon5_2X, $icon5_2Y, $icon5_2Width, $icon5_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon5_2X, $icon5_2Y, $icon5_2Width, $icon5_2Height, $linkUrl);
            }
            for ($pageNo = 11; $pageNo <= 11 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 6_1;
              $pdf->Image($icon1FilePath, $icon6_1X, $icon6_1Y, $icon6_1Width, $icon6_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon6_1X, $icon6_1Y, $icon6_1Width, $icon6_1Height, $linkUrl);
              $iconNo = 6_2;
              $pdf->Image($icon1FilePath, $icon6_2X, $icon6_2Y, $icon6_2Width, $icon6_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon6_2X, $icon6_2Y, $icon6_2Width, $icon6_2Height, $linkUrl);
            }
            for ($pageNo = 12; $pageNo <= 12 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 7;
              $pdf->Image($icon1FilePath, $icon7X, $icon7Y, $icon7Width, $icon7Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon7X, $icon7Y, $icon7Width, $icon7Height, $linkUrl);
            }
            for ($pageNo = 13; $pageNo <= 13 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 8;
              $pdf->Image($icon1FilePath, $icon8X, $icon8Y, $icon8Width, $icon8Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon8X, $icon8Y, $icon8Width, $icon8Height, $linkUrl);
            }
            for ($pageNo = 14; $pageNo <= 14 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 9_1;
              $pdf->Image($icon1FilePath, $icon9_1X, $icon9_1Y, $icon9_1Width, $icon9_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon9_1X, $icon9_1Y, $icon9_1Width, $icon9_1Height, $linkUrl);
              $iconNo = 9_2;
              $pdf->Image($icon1FilePath, $icon9_2X, $icon9_2Y, $icon9_2Width, $icon9_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon9_2X, $icon9_2Y, $icon9_2Width, $icon9_2Height, $linkUrl);
            }
            for ($pageNo = 15; $pageNo <= 15 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 10_1;
              $pdf->Image($icon1FilePath, $icon10_1X, $icon10_1Y, $icon10_1Width, $icon10_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon10_1X, $icon10_1Y, $icon10_1Width, $icon10_1Height, $linkUrl);
              $iconNo = 10_2;
              $pdf->Image($icon1FilePath, $icon10_2X, $icon10_2Y, $icon10_2Width, $icon10_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon10_2X, $icon10_2Y, $icon10_2Width, $icon10_2Height, $linkUrl);
            }
            for ($pageNo = 16; $pageNo <= 16 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
            }
            for ($pageNo = 17; $pageNo <= 17 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 11_1;
              $pdf->Image($icon1FilePath, $icon11_1X, $icon11_1Y, $icon11_1Width, $icon11_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon11_1X, $icon11_1Y, $icon11_1Width, $icon11_1Height, $linkUrl);
              $iconNo = 11_2;
              $pdf->Image($icon1FilePath, $icon11_2X, $icon11_2Y, $icon11_2Width, $icon11_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon11_2X, $icon11_2Y, $icon11_2Width, $icon11_2Height, $linkUrl);
            }
            for ($pageNo = 18; $pageNo <= 18 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 12_1;
              $pdf->Image($icon1FilePath, $icon12_1X, $icon12_1Y, $icon12_1Width, $icon12_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon12_1X, $icon12_1Y, $icon12_1Width, $icon12_1Height, $linkUrl);
              $iconNo = 12_2;
              $pdf->Image($icon1FilePath, $icon12_2X, $icon12_2Y, $icon12_2Width, $icon12_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon12_2X, $icon12_2Y, $icon12_2Width, $icon12_2Height, $linkUrl);
            }
            for ($pageNo = 19; $pageNo <= 19 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
            }
            for ($pageNo = 20; $pageNo <= 20 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 13_1;
              $pdf->Image($icon1FilePath, $icon13_1X, $icon13_1Y, $icon13_1Width, $icon13_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon13_1X, $icon13_1Y, $icon13_1Width, $icon13_1Height, $linkUrl);
              $iconNo = 13_2;
              $pdf->Image($icon1FilePath, $icon13_2X, $icon13_2Y, $icon13_2Width, $icon13_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon13_2X, $icon13_2Y, $icon13_2Width, $icon13_2Height, $linkUrl);
            }
            for ($pageNo = 21; $pageNo <= 21 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 14_1;
              $pdf->Image($icon1FilePath, $icon14_1X, $icon14_1Y, $icon14_1Width, $icon14_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon14_1X, $icon14_1Y, $icon14_1Width, $icon14_1Height, $linkUrl);
              $iconNo = 14_2;
              $pdf->Image($icon1FilePath, $icon14_2X, $icon14_2Y, $icon14_2Width, $icon14_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon14_2X, $icon14_2Y, $icon14_2Width, $icon14_2Height, $linkUrl);
            }
            for ($pageNo = 22; $pageNo <= 22 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 15;
              $pdf->Image($icon1FilePath, $icon15X, $icon15Y, $icon15Width, $icon15Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon15X, $icon15Y, $icon15Width, $icon15Height, $linkUrl);
            }
            for ($pageNo = 23; $pageNo <= 23 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 16;
              $pdf->Image($icon1FilePath, $icon16X, $icon16Y, $icon16Width, $icon16Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon16X, $icon16Y, $icon16Width, $icon16Height, $linkUrl);
            }
            for ($pageNo = 24; $pageNo <= 24 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 17_1;
              $pdf->Image($icon1FilePath, $icon17_1X, $icon17_1Y, $icon17_1Width, $icon17_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon17_1X, $icon17_1Y, $icon17_1Width, $icon17_1Height, $linkUrl);
              $iconNo = 17_2;
              $pdf->Image($icon1FilePath, $icon17_2X, $icon17_2Y, $icon17_2Width, $icon17_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon17_2X, $icon17_2Y, $icon17_2Width, $icon17_2Height, $linkUrl);
            }
            for ($pageNo = 25; $pageNo <= 25 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 18;
              $pdf->Image($icon1FilePath, $icon18X, $icon18Y, $icon18Width, $icon18Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon18X, $icon18Y, $icon18Width, $icon18Height, $linkUrl);
            }
            for ($pageNo = 26; $pageNo <= 26 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 19;
              $pdf->Image($icon1FilePath, $icon19X, $icon19Y, $icon19Width, $icon19Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon19X, $icon19Y, $icon19Width, $icon19Height, $linkUrl);
            }
            for ($pageNo = 27; $pageNo <= 27 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 20_1;
              $pdf->Image($icon1FilePath, $icon20_1X, $icon20_1Y, $icon20_1Width, $icon20_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon20_1X, $icon20_1Y, $icon20_1Width, $icon20_1Height, $linkUrl);
              $iconNo = 20_2;
              $pdf->Image($icon1FilePath, $icon20_2X, $icon20_2Y, $icon20_2Width, $icon20_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon20_2X, $icon20_2Y, $icon20_2Width, $icon20_2Height, $linkUrl);
            }
            for ($pageNo = 28; $pageNo <= 28 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 21;
              $pdf->Image($icon1FilePath, $icon21X, $icon21Y, $icon21Width, $icon21Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon21X, $icon21Y, $icon21Width, $icon21Height, $linkUrl);
            }
            for ($pageNo = 29; $pageNo <= 29 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 22;
              $pdf->Image($icon1FilePath, $icon22X, $icon22Y, $icon22Width, $icon22Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon22X, $icon22Y, $icon22Width, $icon22Height, $linkUrl);
            }
            for ($pageNo = 30; $pageNo <= 30 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 23_1;
              $pdf->Image($icon1FilePath, $icon23_1X, $icon23_1Y, $icon23_1Width, $icon23_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon23_1X, $icon23_1Y, $icon23_1Width, $icon23_1Height, $linkUrl);
              $iconNo = 23_2;
              $pdf->Image($icon1FilePath, $icon23_2X, $icon23_2Y, $icon23_2Width, $icon23_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon23_2X, $icon23_2Y, $icon23_2Width, $icon23_2Height, $linkUrl);
            }
            for ($pageNo = 31; $pageNo <= 31 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 24;
              $pdf->Image($icon1FilePath, $icon24X, $icon24Y, $icon24Width, $icon24Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon24X, $icon24Y, $icon24Width, $icon24Height, $linkUrl);
            }
            for ($pageNo = 32; $pageNo <= 32 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 25;
              $pdf->Image($icon1FilePath, $icon24X, $icon25Y, $icon25Width, $icon25Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon25X, $icon25Y, $icon25Width, $icon25Height, $linkUrl);
            }
            for ($pageNo = 33; $pageNo <= 33 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 26_1;
              $pdf->Image($icon1FilePath, $icon26_1X, $icon26_1Y, $icon26_1Width, $icon26_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon26_1X, $icon26_1Y, $icon26_1Width, $icon26_1Height, $linkUrl);
              $iconNo = 26_2;
              $pdf->Image($icon1FilePath, $icon26_2X, $icon26_2Y, $icon26_2Width, $icon26_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon26_2X, $icon26_2Y, $icon26_2Width, $icon26_2Height, $linkUrl);
            }
            for ($pageNo = 34; $pageNo <= 34 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 27_1;
              $pdf->Image($icon1FilePath, $icon27_1X, $icon27_1Y, $icon27_1Width, $icon27_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon27_1X, $icon27_1Y, $icon27_1Width, $icon27_1Height, $linkUrl);
              $iconNo = 27_2;
              $pdf->Image($icon1FilePath, $icon27_2X, $icon27_2Y, $icon27_2Width, $icon27_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon27_2X, $icon27_2Y, $icon27_2Width, $icon27_2Height, $linkUrl);
            }
            for ($pageNo = 35; $pageNo <= 35 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 28_1;
              $pdf->Image($icon1FilePath, $icon28_1X, $icon28_1Y, $icon28_1Width, $icon28_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon28_1X, $icon28_1Y, $icon28_1Width, $icon28_1Height, $linkUrl);
              $iconNo = 28_2;
              $pdf->Image($icon1FilePath, $icon28_2X, $icon28_2Y, $icon28_2Width, $icon28_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon28_2X, $icon28_2Y, $icon28_2Width, $icon28_2Height, $linkUrl);
            }
            for ($pageNo = 36; $pageNo <= 36 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 29_1;
              $pdf->Image($icon1FilePath, $icon29_1X, $icon29_1Y, $icon29_1Width, $icon29_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon29_1X, $icon29_1Y, $icon29_1Width, $icon29_1Height, $linkUrl);
              $iconNo = 29_2;
              $pdf->Image($icon1FilePath, $icon29_2X, $icon29_2Y, $icon29_2Width, $icon29_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon29_2X, $icon29_2Y, $icon29_2Width, $icon29_2Height, $linkUrl);
            }
            for ($pageNo = 37; $pageNo <= 37 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 30;
              $pdf->Image($icon1FilePath, $icon30X, $icon30Y, $icon30Width, $icon30Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon30X, $icon30Y, $icon30Width, $icon30Height, $linkUrl);
            }
            for ($pageNo = 38; $pageNo <= 38 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 31;
              $pdf->Image($icon1FilePath, $icon31X, $icon31Y, $icon31Width, $icon31Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon31X, $icon31Y, $icon31Width, $icon31Height, $linkUrl);
            }
            for ($pageNo = 39; $pageNo <= 39 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 32;
              $pdf->Image($icon1FilePath, $icon32X, $icon32Y, $icon32Width, $icon32Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon32X, $icon32Y, $icon32Width, $icon32Height, $linkUrl);
            }
            for ($pageNo = 40; $pageNo <= 40 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 33;
              $pdf->Image($icon1FilePath, $icon33X, $icon33Y, $icon33Width, $icon33Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon33X, $icon33Y, $icon33Width, $icon33Height, $linkUrl);
            }
            for ($pageNo = 41; $pageNo <= 41 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 34_1;
              $pdf->Image($icon1FilePath, $icon34_1X, $icon34_1Y, $icon34_1Width, $icon34_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon34_1X, $icon34_1Y, $icon34_1Width, $icon34_1Height, $linkUrl);
              $iconNo = 34_2;
              $pdf->Image($icon1FilePath, $icon34_2X, $icon34_2Y, $icon34_2Width, $icon34_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon34_2X, $icon34_2Y, $icon34_2Width, $icon34_2Height, $linkUrl);
            }
            for ($pageNo = 42; $pageNo <= 42 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
            }
            for ($pageNo = 43; $pageNo <= 43 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 35_1;
              $pdf->Image($icon1FilePath, $icon35_1X, $icon35_1Y, $icon35_1Width, $icon35_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon35_1X, $icon35_1Y, $icon35_1Width, $icon35_1Height, $linkUrl);
              $iconNo = 35_2;
              $pdf->Image($icon1FilePath, $icon35_2X, $icon35_2Y, $icon35_2Width, $icon35_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon35_2X, $icon35_2Y, $icon35_2Width, $icon35_2Height, $linkUrl);
            }
            for ($pageNo = 44; $pageNo <= 44 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 36;
              $pdf->Image($icon1FilePath, $icon36X, $icon36Y, $icon36Width, $icon36Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon36X, $icon36Y, $icon36Width, $icon36Height, $linkUrl);
            }
            for ($pageNo = 45; $pageNo <= 45 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 37;
              $pdf->Image($icon1FilePath, $icon37X, $icon37Y, $icon37Width, $icon37Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon37X, $icon37Y, $icon37Width, $icon37Height, $linkUrl);
            }
            for ($pageNo = 46; $pageNo <= 46 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 38;
              $pdf->Image($icon1FilePath, $icon38X, $icon38Y, $icon38Width, $icon38Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon38X, $icon38Y, $icon38Width, $icon38Height, $linkUrl);
            }
            for ($pageNo = 47; $pageNo <= 47 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 39;
              $pdf->Image($icon1FilePath, $icon39X, $icon39Y, $icon39Width, $icon39Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon39X, $icon39Y, $icon39Width, $icon39Height, $linkUrl);
            }
            for ($pageNo = 48; $pageNo <= 48 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 40;
              $pdf->Image($icon1FilePath, $icon40X, $icon40Y, $icon40Width, $icon40Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon40X, $icon40Y, $icon40Width, $icon40Height, $linkUrl);
            }
            for ($pageNo = 49; $pageNo <= 49 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 41;
              $pdf->Image($icon1FilePath, $icon41X, $icon41Y, $icon41Width, $icon41Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon41X, $icon41Y, $icon41Width, $icon41Height, $linkUrl);
            }
            for ($pageNo = 50; $pageNo <= 50 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 42_1;
              $pdf->Image($icon1FilePath, $icon42_1X, $icon42_1Y, $icon42_1Width, $icon42_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon42_1X, $icon42_1Y, $icon42_1Width, $icon42_1Height, $linkUrl);
              $iconNo = 42_2;
              $pdf->Image($icon1FilePath, $icon42_2X, $icon42_2Y, $icon42_2Width, $icon42_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon42_2X, $icon42_2Y, $icon42_2Width, $icon42_2Height, $linkUrl);
            }
            for ($pageNo = 51; $pageNo <= 51 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 43_1;
              $pdf->Image($icon1FilePath, $icon43_1X, $icon43_1Y, $icon43_1Width, $icon43_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon43_1X, $icon43_1Y, $icon43_1Width, $icon43_1Height, $linkUrl);
              $iconNo = 43_2;
              $pdf->Image($icon1FilePath, $icon43_2X, $icon43_2Y, $icon43_2Width, $icon43_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon43_2X, $icon43_2Y, $icon43_2Width, $icon43_2Height, $linkUrl);
            }
            for ($pageNo = 52; $pageNo <= 52 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 44_1;
              $pdf->Image($icon1FilePath, $icon44_1X, $icon44_1Y, $icon44_1Width, $icon44_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon44_1X, $icon44_1Y, $icon44_1Width, $icon44_1Height, $linkUrl);
              $iconNo = 44_2;
              $pdf->Image($icon1FilePath, $icon44_2X, $icon44_2Y, $icon44_2Width, $icon44_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon44_2X, $icon44_2Y, $icon44_2Width, $icon44_2Height, $linkUrl);
            }
            for ($pageNo = 53; $pageNo <= 53 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 45;
              $pdf->Image($icon1FilePath, $icon45X, $icon45Y, $icon45Width, $icon45Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon45X, $icon45Y, $icon45Width, $icon45Height, $linkUrl);
            }
            for ($pageNo = 54; $pageNo <= 54 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 46;
              $pdf->Image($icon1FilePath, $icon46X, $icon46Y, $icon46Width, $icon46Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon46X, $icon46Y, $icon46Width, $icon46Height, $linkUrl);
            }
            for ($pageNo = 55; $pageNo <= 55 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 47_1;
              $pdf->Image($icon1FilePath, $icon47_1X, $icon47_1Y, $icon47_1Width, $icon47_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon47_1X, $icon47_1Y, $icon47_1Width, $icon47_1Height, $linkUrl);
              $iconNo = 47_2;
              $pdf->Image($icon1FilePath, $icon47_2X, $icon47_2Y, $icon47_2Width, $icon47_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon47_2X, $icon47_2Y, $icon47_2Width, $icon47_2Height, $linkUrl);
            }
            for ($pageNo = 56; $pageNo <= 56 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 48;
              $pdf->Image($icon1FilePath, $icon48X, $icon48Y, $icon48Width, $icon48Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon48X, $icon48Y, $icon48Width, $icon48Height, $linkUrl);
            }
            for ($pageNo = 57; $pageNo <= 57 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 49;
              $pdf->Image($icon1FilePath, $icon49X, $icon49Y, $icon49Width, $icon49Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon49X, $icon49Y, $icon49Width, $icon49Height, $linkUrl);
            }
            for ($pageNo = 58; $pageNo <= 58 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 50_1;
              $pdf->Image($icon1FilePath, $icon50_1X, $icon50_1Y, $icon50_1Width, $icon50_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon50_1X, $icon50_1Y, $icon50_1Width, $icon50_1Height, $linkUrl);
              $iconNo = 50_2;
              $pdf->Image($icon1FilePath, $icon50_2X, $icon50_2Y, $icon50_2Width, $icon50_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon50_2X, $icon50_2Y, $icon50_2Width, $icon50_2Height, $linkUrl);
            }
            for ($pageNo = 59; $pageNo <= 59 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 51;
              $pdf->Image($icon1FilePath, $icon51X, $icon51Y, $icon51Width, $icon51Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon51X, $icon51Y, $icon51Width, $icon51Height, $linkUrl);
            }
            for ($pageNo = 60; $pageNo <= 60 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 52;
              $pdf->Image($icon1FilePath, $icon52X, $icon52Y, $icon52Width, $icon52Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon52X, $icon52Y, $icon52Width, $icon52Height, $linkUrl);
            }
            for ($pageNo = 61; $pageNo <= 61 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 53_1;
              $pdf->Image($icon1FilePath, $icon53_1X, $icon53_1Y, $icon53_1Width, $icon53_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon53_1X, $icon53_1Y, $icon53_1Width, $icon53_1Height, $linkUrl);
              $iconNo = 53_2;
              $pdf->Image($icon1FilePath, $icon53_2X, $icon53_2Y, $icon53_2Width, $icon53_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon53_2X, $icon53_2Y, $icon53_2Width, $icon53_2Height, $linkUrl);
            }
            for ($pageNo = 62; $pageNo <= 62 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 54_1;
              $pdf->Image($icon1FilePath, $icon54_1X, $icon54_1Y, $icon54_1Width, $icon54_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon54_1X, $icon54_1Y, $icon54_1Width, $icon54_1Height, $linkUrl);
              $iconNo = 54_2;
              $pdf->Image($icon1FilePath, $icon54_2X, $icon54_2Y, $icon54_2Width, $icon54_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon54_2X, $icon54_2Y, $icon54_2Width, $icon54_2Height, $linkUrl);
            }
            for ($pageNo = 63; $pageNo <= 63 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
            }
            for ($pageNo = 64; $pageNo <= 64 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 55_1;
              $pdf->Image($icon1FilePath, $icon55_1X, $icon55_1Y, $icon55_1Width, $icon55_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon55_1X, $icon55_1Y, $icon55_1Width, $icon55_1Height, $linkUrl);
              $iconNo = 55_2;
              $pdf->Image($icon1FilePath, $icon55_2X, $icon55_2Y, $icon55_2Width, $icon55_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon55_2X, $icon55_2Y, $icon55_2Width, $icon55_2Height, $linkUrl);
            }
            for ($pageNo = 65; $pageNo <= 65 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 56;
              $pdf->Image($icon1FilePath, $icon56X, $icon56Y, $icon56Width, $icon56Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon56X, $icon56Y, $icon56Width, $icon56Height, $linkUrl);
            }
            for ($pageNo = 66; $pageNo <= 66 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 57;
              $pdf->Image($icon1FilePath, $icon57X, $icon57Y, $icon57Width, $icon57Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon57X, $icon57Y, $icon57Width, $icon57Height, $linkUrl);
            }
            for ($pageNo = 67; $pageNo <= 67 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 58;
              $pdf->Image($icon1FilePath, $icon58X, $icon58Y, $icon58Width, $icon58Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon58X, $icon58Y, $icon58Width, $icon58Height, $linkUrl);
            }
            for ($pageNo = 68; $pageNo <= 68 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 59_1;
              $pdf->Image($icon1FilePath, $icon59_1X, $icon59_1Y, $icon59_1Width, $icon59_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon59_1X, $icon59_1Y, $icon59_1Width, $icon59_1Height, $linkUrl);
              $iconNo = 59_2;
              $pdf->Image($icon1FilePath, $icon59_2X, $icon59_2Y, $icon59_2Width, $icon59_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon59_2X, $icon59_2Y, $icon59_2Width, $icon59_2Height, $linkUrl);
            }
            for ($pageNo = 69; $pageNo <= 69 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 60_1;
              $pdf->Image($icon1FilePath, $icon60_1X, $icon60_1Y, $icon60_1Width, $icon60_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon60_1X, $icon60_1Y, $icon60_1Width, $icon60_1Height, $linkUrl);
              $iconNo = 60_2;
              $pdf->Image($icon1FilePath, $icon60_2X, $icon60_2Y, $icon60_2Width, $icon60_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon60_2X, $icon60_2Y, $icon60_2Width, $icon60_2Height, $linkUrl);
            }
            for ($pageNo = 70; $pageNo <= 70 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 61_1;
              $pdf->Image($icon1FilePath, $icon61_1X, $icon61_1Y, $icon61_1Width, $icon61_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon61_1X, $icon61_1Y, $icon61_1Width, $icon61_1Height, $linkUrl);
              $iconNo = 61_2;
              $pdf->Image($icon1FilePath, $icon61_2X, $icon61_2Y, $icon61_2Width, $icon61_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon61_2X, $icon61_2Y, $icon61_2Width, $icon61_2Height, $linkUrl);
            }
            for ($pageNo = 71; $pageNo <= 71 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 62_1;
              $pdf->Image($icon1FilePath, $icon62_1X, $icon62_1Y, $icon62_1Width, $icon62_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon62_1X, $icon62_1Y, $icon62_1Width, $icon62_1Height, $linkUrl);
              $iconNo = 62_2;
              $pdf->Image($icon1FilePath, $icon62_2X, $icon62_2Y, $icon62_2Width, $icon62_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon62_2X, $icon62_2Y, $icon62_2Width, $icon62_2Height, $linkUrl);
            }
            for ($pageNo = 72; $pageNo <= 72 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 63_1;
              $pdf->Image($icon1FilePath, $icon63_1X, $icon63_1Y, $icon63_1Width, $icon63_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon63_1X, $icon63_1Y, $icon63_1Width, $icon63_1Height, $linkUrl);
              $iconNo = 63_2;
              $pdf->Image($icon1FilePath, $icon63_2X, $icon63_2Y, $icon63_2Width, $icon63_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon63_2X, $icon63_2Y, $icon63_2Width, $icon63_2Height, $linkUrl);
            }
            for ($pageNo = 73; $pageNo <= 73 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 64_1;
              $pdf->Image($icon1FilePath, $icon64_1X, $icon64_1Y, $icon64_1Width, $icon64_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon64_1X, $icon64_1Y, $icon64_1Width, $icon64_1Height, $linkUrl);
              $iconNo = 64_2;
              $pdf->Image($icon1FilePath, $icon64_2X, $icon64_2Y, $icon64_2Width, $icon64_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon64_2X, $icon64_2Y, $icon64_2Width, $icon64_2Height, $linkUrl);
            }
            for ($pageNo = 74; $pageNo <= 74 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 65_1;
              $pdf->Image($icon1FilePath, $icon65_1X, $icon65_1Y, $icon65_1Width, $icon65_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon65_1X, $icon65_1Y, $icon65_1Width, $icon65_1Height, $linkUrl);
              $iconNo = 65_2;
              $pdf->Image($icon1FilePath, $icon65_2X, $icon65_2Y, $icon65_2Width, $icon65_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon65_2X, $icon65_2Y, $icon65_2Width, $icon65_2Height, $linkUrl);
            }
            for ($pageNo = 75; $pageNo <= 75 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 66_1;
              $pdf->Image($icon1FilePath, $icon66_1X, $icon66_1Y, $icon66_1Width, $icon66_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon66_1X, $icon66_1Y, $icon66_1Width, $icon66_1Height, $linkUrl);
              $iconNo = 66_2;
              $pdf->Image($icon1FilePath, $icon66_2X, $icon66_2Y, $icon66_2Width, $icon66_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon66_2X, $icon66_2Y, $icon66_2Width, $icon66_2Height, $linkUrl);
            }
            for ($pageNo = 76; $pageNo <= 76 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 67_1;
              $pdf->Image($icon1FilePath, $icon67_1X, $icon67_1Y, $icon67_1Width, $icon67_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon67_1X, $icon67_1Y, $icon67_1Width, $icon67_1Height, $linkUrl);
              $iconNo = 67_2;
              $pdf->Image($icon1FilePath, $icon67_2X, $icon67_2Y, $icon67_2Width, $icon67_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon67_2X, $icon67_2Y, $icon67_2Width, $icon67_2Height, $linkUrl);
            }
            for ($pageNo = 77; $pageNo <= 77 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 68_1;
              $pdf->Image($icon1FilePath, $icon68_1X, $icon68_1Y, $icon68_1Width, $icon68_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon68_1X, $icon68_1Y, $icon68_1Width, $icon68_1Height, $linkUrl);
              $iconNo = 68_2;
              $pdf->Image($icon1FilePath, $icon68_2X, $icon68_2Y, $icon68_2Width, $icon68_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon68_2X, $icon68_2Y, $icon68_2Width, $icon68_2Height, $linkUrl);
            }
            for ($pageNo = 78; $pageNo <= 78 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 69_1;
              $pdf->Image($icon1FilePath, $icon69_1X, $icon69_1Y, $icon69_1Width, $icon69_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon69_1X, $icon69_1Y, $icon69_1Width, $icon69_1Height, $linkUrl);
              $iconNo = 69_2;
              $pdf->Image($icon1FilePath, $icon69_2X, $icon69_2Y, $icon69_2Width, $icon69_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon69_2X, $icon69_2Y, $icon69_2Width, $icon69_2Height, $linkUrl);
            }
            for ($pageNo = 79; $pageNo <= 79 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 70_1;
              $pdf->Image($icon1FilePath, $icon70_1X, $icon70_1Y, $icon70_1Width, $icon70_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon70_1X, $icon70_1Y, $icon70_1Width, $icon70_1Height, $linkUrl);
              $iconNo = 70_2;
              $pdf->Image($icon1FilePath, $icon70_2X, $icon70_2Y, $icon70_2Width, $icon70_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon70_2X, $icon70_2Y, $icon70_2Width, $icon70_2Height, $linkUrl);
            }
            for ($pageNo = 80; $pageNo <= 80 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 80;
              $pdf->Image($icon1FilePath, $icon80X, $icon80Y, $icon80Width, $icon80Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon80X, $icon80Y, $icon80Width, $icon80Height, $linkUrl);
            }
            for ($pageNo = 81; $pageNo <= 81 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 81_1;
              $pdf->Image($icon1FilePath, $icon81_1X, $icon81_1Y, $icon81_1Width, $icon81_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon81_1X, $icon81_1Y, $icon81_1Width, $icon81_1Height, $linkUrl);
              $iconNo = 81_2;
              $pdf->Image($icon1FilePath, $icon81_2X, $icon81_2Y, $icon81_2Width, $icon81_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon81_2X, $icon81_2Y, $icon81_2Width, $icon81_2Height, $linkUrl);
            }
            for ($pageNo = 82; $pageNo <= 82 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 82;
              $pdf->Image($icon1FilePath, $icon82X, $icon82Y, $icon82Width, $icon82Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon82X, $icon82Y, $icon82Width, $icon82Height, $linkUrl);
            }
            for ($pageNo = 83; $pageNo <= 83 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 83_1;
              $pdf->Image($icon1FilePath, $icon83_1X, $icon83_1Y, $icon83_1Width, $icon83_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon83_1X, $icon83_1Y, $icon83_1Width, $icon83_1Height, $linkUrl);
              $iconNo = 83_2;
              $pdf->Image($icon1FilePath, $icon83_2X, $icon83_2Y, $icon83_2Width, $icon83_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon83_2X, $icon83_2Y, $icon83_2Width, $icon83_2Height, $linkUrl);
            }
            for ($pageNo = 84; $pageNo <= 84 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 84_1;
              $pdf->Image($icon1FilePath, $icon84_1X, $icon84_1Y, $icon84_1Width, $icon84_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon84_1X, $icon84_1Y, $icon84_1Width, $icon84_1Height, $linkUrl);
              $iconNo = 84_2;
              $pdf->Image($icon1FilePath, $icon84_2X, $icon84_2Y, $icon84_2Width, $icon84_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon84_2X, $icon84_2Y, $icon84_2Width, $icon84_2Height, $linkUrl);
            }
            for ($pageNo = 85; $pageNo <= 85 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 85_1;
              $pdf->Image($icon1FilePath, $icon85_1X, $icon85_1Y, $icon85_1Width, $icon85_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon85_1X, $icon85_1Y, $icon85_1Width, $icon85_1Height, $linkUrl);
              $iconNo = 85_2;
              $pdf->Image($icon1FilePath, $icon85_2X, $icon85_2Y, $icon85_2Width, $icon85_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon85_2X, $icon85_2Y, $icon85_2Width, $icon85_2Height, $linkUrl);
            }
            for ($pageNo = 86; $pageNo <= 86 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 86_1;
              $pdf->Image($icon1FilePath, $icon86_1X, $icon86_1Y, $icon86_1Width, $icon86_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon86_1X, $icon86_1Y, $icon86_1Width, $icon86_1Height, $linkUrl);
              $iconNo = 86_2;
              $pdf->Image($icon1FilePath, $icon86_2X, $icon86_2Y, $icon86_2Width, $icon86_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon86_2X, $icon86_2Y, $icon86_2Width, $icon86_2Height, $linkUrl);
            }
            for ($pageNo = 87; $pageNo <= 87 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 87_1;
              $pdf->Image($icon1FilePath, $icon87_1X, $icon87_1Y, $icon87_1Width, $icon87_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon87_1X, $icon87_1Y, $icon87_1Width, $icon87_1Height, $linkUrl);
              $iconNo = 87_2;
              $pdf->Image($icon1FilePath, $icon87_2X, $icon87_2Y, $icon87_2Width, $icon87_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon87_2X, $icon87_2Y, $icon87_2Width, $icon87_2Height, $linkUrl);
            }
            for ($pageNo = 88; $pageNo <= 88 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 88_1;
              $pdf->Image($icon1FilePath, $icon88_1X, $icon88_1Y, $icon88_1Width, $icon88_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon88_1X, $icon88_1Y, $icon88_1Width, $icon88_1Height, $linkUrl);
              $iconNo = 88_2;
              $pdf->Image($icon1FilePath, $icon88_2X, $icon88_2Y, $icon88_2Width, $icon88_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon88_2X, $icon88_2Y, $icon88_2Width, $icon88_2Height, $linkUrl);
            }
            for ($pageNo = 89; $pageNo <= 89 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 89_1;
              $pdf->Image($icon1FilePath, $icon89_1X, $icon89_1Y, $icon89_1Width, $icon89_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon89_1X, $icon89_1Y, $icon89_1Width, $icon89_1Height, $linkUrl);
              $iconNo = 89_2;
              $pdf->Image($icon1FilePath, $icon89_2X, $icon89_2Y, $icon89_2Width, $icon89_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon89_2X, $icon89_2Y, $icon89_2Width, $icon89_2Height, $linkUrl);
            }
            for ($pageNo = 90; $pageNo <= 90 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 90;
              $pdf->Image($icon1FilePath, $icon90X, $icon90Y, $icon90Width, $icon90Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon90X, $icon90Y, $icon90Width, $icon90Height, $linkUrl);
            }
            for ($pageNo = 91; $pageNo <= 91 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 91;
              $pdf->Image($icon1FilePath, $icon91X, $icon91Y, $icon91Width, $icon91Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon91X, $icon91Y, $icon91Width, $icon91Height, $linkUrl);
            }
            for ($pageNo = 92; $pageNo <= 92 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 92_1;
              $pdf->Image($icon1FilePath, $icon92_1X, $icon92_1Y, $icon92_1Width, $icon92_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon92_1X, $icon92_1Y, $icon92_1Width, $icon92_1Height, $linkUrl);
              $iconNo = 92_2;
              $pdf->Image($icon1FilePath, $icon92_2X, $icon92_2Y, $icon92_2Width, $icon92_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon92_2X, $icon92_2Y, $icon92_2Width, $icon92_2Height, $linkUrl);
            }
            for ($pageNo = 93; $pageNo <= 93 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 93_1;
              $pdf->Image($icon1FilePath, $icon93_1X, $icon93_1Y, $icon93_1Width, $icon93_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon93_1X, $icon93_1Y, $icon93_1Width, $icon93_1Height, $linkUrl);
              $iconNo = 93_2;
              $pdf->Image($icon1FilePath, $icon93_2X, $icon93_2Y, $icon93_2Width, $icon93_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon93_2X, $icon93_2Y, $icon93_2Width, $icon93_2Height, $linkUrl);
            }
            for ($pageNo = 94; $pageNo <= 94 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 94_1;
              $pdf->Image($icon1FilePath, $icon94_1X, $icon94_1Y, $icon94_1Width, $icon94_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon94_1X, $icon94_1Y, $icon94_1Width, $icon94_1Height, $linkUrl);
              $iconNo = 94_2;
              $pdf->Image($icon1FilePath, $icon94_2X, $icon94_2Y, $icon94_2Width, $icon94_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon94_2X, $icon94_2Y, $icon94_2Width, $icon94_2Height, $linkUrl);
            }
            for ($pageNo = 95; $pageNo <= 95 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 95;
              $pdf->Image($icon1FilePath, $icon95X, $icon95Y, $icon95Width, $icon95Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon95X, $icon95Y, $icon95Width, $icon95Height, $linkUrl);
            }
            for ($pageNo = 96; $pageNo <= 96 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 96;
              $pdf->Image($icon1FilePath, $icon96X, $icon96Y, $icon96Width, $icon96Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon96X, $icon96Y, $icon96Width, $icon96Height, $linkUrl);
            }
            for ($pageNo = 97; $pageNo <= 97 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 97_1;
              $pdf->Image($icon1FilePath, $icon97_1X, $icon97_1Y, $icon97_1Width, $icon97_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon97_1X, $icon97_1Y, $icon97_1Width, $icon97_1Height, $linkUrl);
              $iconNo = 97_2;
              $pdf->Image($icon1FilePath, $icon97_2X, $icon97_2Y, $icon97_2Width, $icon97_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon97_2X, $icon97_2Y, $icon97_2Width, $icon97_2Height, $linkUrl);
            }
            for ($pageNo = 98; $pageNo <= 98 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 98_1;
              $pdf->Image($icon1FilePath, $icon98_1X, $icon98_1Y, $icon98_1Width, $icon98_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon98_1X, $icon98_1Y, $icon98_1Width, $icon98_1Height, $linkUrl);
              $iconNo = 98_2;
              $pdf->Image($icon1FilePath, $icon98_2X, $icon98_2Y, $icon98_2Width, $icon98_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon98_2X, $icon98_2Y, $icon98_2Width, $icon98_2Height, $linkUrl);
            }
            for ($pageNo = 99; $pageNo <= 99 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 99;
              $pdf->Image($icon1FilePath, $icon99X, $icon99Y, $icon99Width, $icon99Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon99X, $icon99Y, $icon99Width, $icon99Height, $linkUrl);
            }
            for ($pageNo = 100; $pageNo <= 100 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 100_1;
              $pdf->Image($icon1FilePath, $icon100_1X, $icon100_1Y, $icon100_1Width, $icon100_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon100_1X, $icon100_1Y, $icon100_1Width, $icon100_1Height, $linkUrl);
              $iconNo = 100_2;
              $pdf->Image($icon1FilePath, $icon100_2X, $icon100_2Y, $icon100_2Width, $icon100_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon100_2X, $icon100_2Y, $icon100_2Width, $icon100_2Height, $linkUrl);
            }
            for ($pageNo = 101; $pageNo <= 101 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 101;
              $pdf->Image($icon1FilePath, $icon101X, $icon101Y, $icon101Width, $icon101Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon101X, $icon101Y, $icon101Width, $icon101Height, $linkUrl);
            }
            for ($pageNo = 102; $pageNo <= 102 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 102_1;
              $pdf->Image($icon1FilePath, $icon102_1X, $icon102_1Y, $icon102_1Width, $icon102_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon102_1X, $icon102_1Y, $icon102_1Width, $icon102_1Height, $linkUrl);
              $iconNo = 102_2;
              $pdf->Image($icon1FilePath, $icon102_2X, $icon102_2Y, $icon102_2Width, $icon102_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon102_2X, $icon102_2Y, $icon102_2Width, $icon102_2Height, $linkUrl);
            }
            for ($pageNo = 103; $pageNo <= 103 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 103_1;
              $pdf->Image($icon1FilePath, $icon103_1X, $icon103_1Y, $icon103_1Width, $icon103_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon103_1X, $icon103_1Y, $icon103_1Width, $icon103_1Height, $linkUrl);
              $iconNo = 103_2;
              $pdf->Image($icon1FilePath, $icon103_2X, $icon103_2Y, $icon103_2Width, $icon103_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon103_2X, $icon103_2Y, $icon103_2Width, $icon103_2Height, $linkUrl);
            }
            for ($pageNo = 104; $pageNo <= 104 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 104_1;
              $pdf->Image($icon1FilePath, $icon104_1X, $icon104_1Y, $icon104_1Width, $icon104_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon104_1X, $icon104_1Y, $icon104_1Width, $icon104_1Height, $linkUrl);
              $iconNo = 104_2;
              $pdf->Image($icon1FilePath, $icon104_2X, $icon104_2Y, $icon104_2Width, $icon104_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon104_2X, $icon104_2Y, $icon104_2Width, $icon104_2Height, $linkUrl);
            }
            for ($pageNo = 105; $pageNo <= 105 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 105_1;
              $pdf->Image($icon1FilePath, $icon105_1X, $icon105_1Y, $icon105_1Width, $icon105_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon105_1X, $icon105_1Y, $icon105_1Width, $icon105_1Height, $linkUrl);
              $iconNo = 105_2;
              $pdf->Image($icon1FilePath, $icon105_2X, $icon105_2Y, $icon105_2Width, $icon105_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon105_2X, $icon105_2Y, $icon105_2Width, $icon105_2Height, $linkUrl);
            }
            for ($pageNo = 106; $pageNo <= 106 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 106_1;
              $pdf->Image($icon1FilePath, $icon106_1X, $icon106_1Y, $icon106_1Width, $icon106_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon106_1X, $icon106_1Y, $icon106_1Width, $icon106_1Height, $linkUrl);
              $iconNo = 106_2;
              $pdf->Image($icon1FilePath, $icon106_2X, $icon106_2Y, $icon106_2Width, $icon106_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon106_2X, $icon106_2Y, $icon106_2Width, $icon106_2Height, $linkUrl);
            }
            for ($pageNo = 107; $pageNo <= 107 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 107_1;
              $pdf->Image($icon1FilePath, $icon107_1X, $icon107_1Y, $icon107_1Width, $icon107_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon107_1X, $icon107_1Y, $icon107_1Width, $icon107_1Height, $linkUrl);
              $iconNo = 107_2;
              $pdf->Image($icon1FilePath, $icon107_2X, $icon107_2Y, $icon107_2Width, $icon107_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon107_2X, $icon107_2Y, $icon107_2Width, $icon107_2Height, $linkUrl);
            }
            for ($pageNo = 108; $pageNo <= 108 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 108_1;
              $pdf->Image($icon1FilePath, $icon108_1X, $icon108_1Y, $icon108_1Width, $icon108_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon108_1X, $icon108_1Y, $icon108_1Width, $icon108_1Height, $linkUrl);
              $iconNo = 108_2;
              $pdf->Image($icon1FilePath, $icon108_2X, $icon108_2Y, $icon108_2Width, $icon108_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon108_2X, $icon108_2Y, $icon108_2Width, $icon108_2Height, $linkUrl);
            }
            for ($pageNo = 109; $pageNo <= 109 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 109_1;
              $pdf->Image($icon1FilePath, $icon109_1X, $icon109_1Y, $icon109_1Width, $icon109_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon109_1X, $icon109_1Y, $icon109_1Width, $icon109_1Height, $linkUrl);
              $iconNo = 109_2;
              $pdf->Image($icon1FilePath, $icon109_2X, $icon109_2Y, $icon109_2Width, $icon109_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon109_2X, $icon109_2Y, $icon109_2Width, $icon109_2Height, $linkUrl);
            }
            for ($pageNo = 110; $pageNo <= 110 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 110;
              $pdf->Image($icon1FilePath, $icon110X, $icon110Y, $icon110Width, $icon110Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon110X, $icon110Y, $icon110Width, $icon110Height, $linkUrl);
            }
            for ($pageNo = 111; $pageNo <= 111 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 111;
              $pdf->Image($icon1FilePath, $icon111X, $icon111Y, $icon111Width, $icon111Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon111X, $icon111Y, $icon111Width, $icon111Height, $linkUrl);
            }
            for ($pageNo = 112; $pageNo <= 112 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 112;
              $pdf->Image($icon1FilePath, $icon112X, $icon112Y, $icon112Width, $icon112Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon112X, $icon112Y, $icon112Width, $icon112Height, $linkUrl);
            }
            for ($pageNo = 113; $pageNo <= 113 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 113;
              $pdf->Image($icon1FilePath, $icon113X, $icon113Y, $icon113Width, $icon113Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon113X, $icon113Y, $icon113Width, $icon113Height, $linkUrl);
            }
            for ($pageNo = 114; $pageNo <= 114 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 114_1;
              $pdf->Image($icon1FilePath, $icon114_1X, $icon114_1Y, $icon114_1Width, $icon114_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon114_1X, $icon114_1Y, $icon114_1Width, $icon114_1Height, $linkUrl);
              $iconNo = 114_2;
              $pdf->Image($icon1FilePath, $icon114_2X, $icon114_2Y, $icon114_2Width, $icon114_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon114_2X, $icon114_2Y, $icon114_2Width, $icon114_2Height, $linkUrl);
            }
            for ($pageNo = 115; $pageNo <= 115 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 115;
              $pdf->Image($icon1FilePath, $icon115X, $icon115Y, $icon115Width, $icon115Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon115X, $icon115Y, $icon115Width, $icon115Height, $linkUrl);
            }
            for ($pageNo = 116; $pageNo <= 116 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 116;
              $pdf->Image($icon1FilePath, $icon116X, $icon116Y, $icon116Width, $icon116Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon116X, $icon116Y, $icon116Width, $icon116Height, $linkUrl);
            }
            for ($pageNo = 117; $pageNo <= 117 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 117_1;
              $pdf->Image($icon1FilePath, $icon117_1X, $icon117_1Y, $icon117_1Width, $icon117_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon117_1X, $icon117_1Y, $icon117_1Width, $icon117_1Height, $linkUrl);
              $iconNo = 117_2;
              $pdf->Image($icon1FilePath, $icon117_2X, $icon117_2Y, $icon117_2Width, $icon117_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon117_2X, $icon117_2Y, $icon117_2Width, $icon117_2Height, $linkUrl);
            }
            for ($pageNo = 118; $pageNo <= 118 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
            }
            for ($pageNo = 119; $pageNo <= 119 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
              $iconNo = 118_1;
              $pdf->Image($icon1FilePath, $icon118_1X, $icon118_1Y, $icon118_1Width, $icon118_1Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon118_1X, $icon118_1Y, $icon118_1Width, $icon118_1Height, $linkUrl);
              $iconNo = 118_2;
              $pdf->Image($icon1FilePath, $icon118_2X, $icon118_2Y, $icon118_2Width, $icon118_2Height, 'PNG');
              $linkUrl = $linkUrlBase  . $iconUrlParam . $iconNo . $pageUrlParam . $pageNo;
              $pdf->Link($icon118_2X, $icon118_2Y, $icon118_2Width, $icon118_2Height, $linkUrl);
            }
            for ($pageNo = 120; $pageNo <= 122 ; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $pdf->addPage();
              $pdf->useTemplate($templateId);
            }
        }
      
      
        if(!empty($pdf)){
          $pdf->Output($pdfFilePath1, 'F');
        }

        $pdfPath = 'Mathematique.pdf';
  
        $enfants = Enfant::where("parent_id", "=", auth()->user()->id)->orderBy("id", "desc")->with('level')->get();
        
        $data = [
          'optiontearcher' => $optiontearcher,
          'sectionm' => $sectionm,
          'levelm' => $levelm,
        ];

        $guideProgress = is_string($user->guide_progress) ? json_decode($user->guide_progress, true) : $user->guide_progress;

      
       if (request()->path() === 'panel/scolaire/' . $id && request()->query('icon') == $icon && request()->query('page') == $page) {
        $data['pageTitle'] = $videostitleAll->titleAll ?? ' الكتب المدرسيّة ' . ' ' . $Manuelsname[0];
        } elseif(request()->is('panel/scolaire/'.$id)) {
            $data['pageTitle'] = ' الكتب المدرسيّة ' . ' ' . $Manuelsname[0];
        }

        return view(getTemplate() . '.panel.Manuel_scolaire.lisr_free_parser', $data, [
          'isSubscribed' => $isSubscribed,
          'subscriptions' => $subscriptions,
          'Manuels'=> $Manuels,
          'page' =>  $page,
          'videos' => $videos,
          'id' => $id,
          'videostitleAll' => $videostitleAll,
          'math' => $math,
          'matiere' => $matiere,
          'pdfPath' => $pdfFilePath2,
          'enfants' => $enfants,
          't3DPathManuels'=>$t3DPathManuels,
          'guide_progress' => $guideProgress["manuel"] ?? [],

        ]);
  }
  public function methode2($id)
  {
    $user = auth()->user();
    $Manuelsname = Manuels::where('id', $id)->pluck('name');
    $documents = Document::where('manuel_id', $id)->pluck('pdf');
    $page = request('page');
    $pdfFilePath1 = public_path($documents[0]) ;
    $pdfFilePath2 = env('APP_ENV_URL1').$documents[0];
    $pdfFilePath = env('APP_ENV_URL1').'/'.$documents[0];

    if(!empty($pdf)){

    $pdf->Output($pdfFilePath1,'F');
    }
    $pdfPath = public_path('pdf/Mathematique1.pdf');
    $destinationPath = storage_path('app/public/pdf/Mathematique1.pdf');
     $destinationDir = dirname($destinationPath);
    if (!File::exists($destinationDir)) {
        File::makeDirectory($destinationDir, 0755, true);
    }
    if (File::exists($pdfPath)) {
        File::move($pdfPath, $destinationPath);
    }
    $users1 = User::where('id', auth()->user()->id)->get();
    $user1 = User::where('id', auth()->user()->id)->pluck('id');
    $startOfYear = now()->startOfYear()->toDateTimeString();
    $endOfYear = now()->endOfYear()->toDateTimeString();
    $videos1 = Video::where('user_id', $user1)->whereBetween('created_at', [$startOfYear, $endOfYear])->get();
    $datay = $videos1->groupBy(function ($video1) {
      return $video1->created_at->format('F');

    })->sortBy(function ($group, $month) {
      return Carbon::parse($month)->month;
    })->map(function ($group) {
      $vues = $group->sum('vues');
      $likes = $group->sum('likes');
      return [
        'vues' => $vues,
        'likes' => $likes,
      ];
    });

    $yearChartData = $datay->toJson();
    $startOfMonth = now()->startOfMonth()->toDateTimeString();
    $endOfMonth = now()->endOfMonth()->toDateTimeString();

    $videos1 = Video::where('user_id', $user1)->whereRaw('created_at >= ? AND created_at <= ?', [$startOfMonth, $endOfMonth])->get();
    $datad = $videos1->groupBy(function ($video1) {
      return $video1->created_at->format('d/l');
    })->map(function ($group) {
      $vues = $group->sum('vues');
      $likes = $group->sum('likes');

      return [
        'vues' => $vues,
        'likes' => $likes,
      ];
    });
    $dayChartData = $datad->toJson();
    $vue = Video::where('user_id', $user1)->sum('vues');
    $vuemanul = Video::where('user_id', $user1)->where('manuel_id',$id)->sum('vues');

    $video1 = Video::where('user_id', $user1)->count();
    $vid = Video::where('user_id', $user1)->get();
   
   
    $userLevelIds = UserLevel::where('teacher_id', $user->id)->pluck('level_id');
    $userLevelIds1 = UserLevel::where('teacher_id', $user->id)->pluck('level_id');

    $listmatieree = UserMatiere::where('teacher_id', $user->id)->pluck('matiere_id');
    $matiereNames = [];
    $matiereNames1 = []; 

    foreach ($listmatieree as $matiereId) {
      
      $matiereName = Material::where('id', $matiereId)->pluck('name')->first(); 
          if (!is_null($matiereName)) {
          $matiereNames1[] = $matiereName;
          }
    }
    foreach ($listmatieree as $matiereId) {
      $matiereName = Material::where('id', $matiereId)->pluck('name'); 
          if (!is_null($matiereName)) {
          $matiereNames[] = $matiereName;
          }
    }

             $filteredMatiere1 = [];
            foreach ($matiereNames as $matierej) {

                $filteredMatiere12 = Material::where('name', $matierej[0])
                    ->with(['section' => function ($query) use ($userLevelIds1) {
                        $query->whereIn('level_id',$userLevelIds1)->with('level');
                    }])->get();
                $filteredMatiere1[] =  $filteredMatiere12;
            }
            $sss = UserMatiere::where('teacher_id', auth()->user()->id)->pluck('matiere_id');

            $loadedPaths = [];
            $matiere111 = [];
            $matiere22 = [];
            foreach ($filteredMatiere1 as $key => $collection) {
                $filteredCollection = $collection->filter(function ($matiere22) use (&$loadedPaths) {
                    if (!is_null($matiere22->section) && !in_array($matiere22->path, $loadedPaths)) {
                        $loadedPaths[] = $matiere22->path;
                        return true;
                    }
                    return false;
                });
                if (!$filteredCollection->isEmpty()) {
                    $matiere111[$key] = $filteredCollection;
                }
            }


            $materialIds = [];
            foreach ($matiere111 as $collection) {
                foreach ($collection as $material) {
                    if (!in_array($material->id, $materialIds)) {
                        $materialIds[] = $material->id;
                    }
                }
            }
            $Manuels = Manuels::whereIn('material_id', $sss)
            ->with([
                'matiere' => function ($query) {
                    $query->with(['section' => function ($query) {
                        $query->with('level');
                    }]);
                }
            ])->get();
            $videocountbymanul = Video::where('user_id', $user->id)->with('manuel')
            ->where('manuel_id', $id)
            ->count();

            $distinctvideocountbymanul = Video::where('user_id', $user->id)->with('manuel')
            ->where('manuel_id', $id)
            ->groupBy('numero', 'page')
            ->get()
            ->count();

            $totalIconAddInManuels=Document::where('manuel_id', $id)->pluck('nombre_page');
            $t3DPathManuels= Document::where('manuel_id', $id)->pluck('3d_path_teacher');


            $pdfPath= '/Abajim/storage/app/public/pdf/Mathematique1.pdf';

            return view(getTemplate() . '.panel.Manuel_scolaire.listteacher', [
              'pageTitle' => ' الكتب المدرسيّة '.' '.$Manuelsname[0],
              'userLevelIds'=>$userLevelIds,
              'totalIconAddInManuels'=> $totalIconAddInManuels,
              'videocountbymanul'=>$videocountbymanul,
              'id' => $id,
              'yearChartData' => $yearChartData,
              'dayChartData' => $dayChartData,
              'users1' => $users1,
              'vue' => $vue,
              'vuemanul' =>$vuemanul,
              'vid' => $vid,
              'video1' => $video1,
              'matiereNames'=>$matiereNames1,
              'Manuels' => $Manuels,
              't3DPathManuels'=>$t3DPathManuels,
              'pdfPath' => $pdfPath,
              'pdfFilePath' => $pdfFilePath2,
              'page' =>  $page,
              'distinctvideocountbymanul' => $distinctvideocountbymanul,

            ]);
  }

  public function methode3($id)
  {

    if (preg_match('/(\d+)icon/', $id, $matches)) {
      $number = $matches[1];
    }
    $Manuelsname = Manuels::where('id', $id)->pluck('name');
    $documents = Document::where('manuel_id', $id)->pluck('pdf');
    $user = auth()->user();
    $userLevelIds = UserLevel::where('teacher_id', $user->id)->pluck('level_id');

    $matiereNames = []; // Array to store the names of materials
    $userLevelIds1 = UserLevel::where('teacher_id', $user->id)->pluck('level_id');

    $listmatieree = UserMatiere::where('teacher_id', $user->id)->pluck('matiere_id');
    $matiereNames = []; // Array to store the names of materials
    $matiereNames1 = []; // Array to store the names of materials

    foreach ($listmatieree as $matiereId) {
      $matiereName = Material::where('id', $matiereId)->pluck('name')->first();
          if (!is_null($matiereName)) {
          $matiereNames1[] = $matiereName;
          }
    }
    foreach ($listmatieree as $matiereId) {
      
      $matiereName = Material::where('id', $matiereId)->pluck('name');
          if (!is_null($matiereName)) { // Check if matiereName is not null
          $matiereNames[] = $matiereName;
          }
    }
   // dd( $matiereNames);
  
        // Now, $matiereNames contains all the names of the materials taught by the teacher
         // Let's filter Manuels based on these names

             $filteredMatiere1 = [];
            foreach ($matiereNames as $matierej) {

                $filteredMatiere12 = Material::where('name', $matierej[0])
                    ->with(['section' => function ($query) use ($userLevelIds1) {
                        $query->whereIn('level_id',$userLevelIds1)->with('level');
                    }])->get();
                $filteredMatiere1[] =  $filteredMatiere12;
            }
       
            // Initialize an array to keep track of loaded paths
            $loadedPaths = [];

            // Initialize an array to store the filtered results
            $matiere111 = [];
            $matiere22 = [];
            foreach ($filteredMatiere1 as $key => $collection) {
                // Apply the filter to each collection
                $filteredCollection = $collection->filter(function ($matiere22) use (&$loadedPaths) {
                    // Check if the section is not null and the path is not already loaded
                    if (!is_null($matiere22->section) && !in_array($matiere22->path, $loadedPaths)) {
                        $loadedPaths[] = $matiere22->path;
                        return true;
                    }
                    return false;
                });

                // Store the filtered collection if it is not empty
                if (!$filteredCollection->isEmpty()) {
                    $matiere111[$key] = $filteredCollection;
                }
            }


            $materialIds = [];

    foreach ($matiere111 as $collection) {
    foreach ($collection as $material) {
        if (!in_array($material->id, $materialIds)) {
            // Add unique Material ID to the array
            $materialIds[] = $material->id;
        }
    }
    }
      $sss = UserMatiere::where('teacher_id', auth()->user()->id)->pluck('matiere_id');

      $Manuels = Manuels::whereIn('material_id',$sss)
      ->with([
          'matiere' => function ($query) {
              $query->with(['section' => function ($query) {
                  $query->with('level');
              }]);
          }
      ])->get();
      $pdfFilePath = 'http://localhost:8004/'.$documents[0];
      $pdfFilePath2 = 'http://localhost:8004/'.$documents[0];

    $icon = request('icon');
    $page = request('page');
    $t3DPathManuels= Document::where('manuel_id', $id)->pluck('3d_path_teacher');

    return view(getTemplate() . '.panel.Manuel_scolaire.listviewteacher', [
      'pageTitle' => ' الكتب المدرسيّة '.' '.$Manuelsname[0],
      'Manuels' => $Manuels,
      'id' => $id,
      'icon' => $icon,
      'page' => $page,
      't3DPathManuels' => $t3DPathManuels,
      'pdfFilePath' => $pdfFilePath2,

    ]);
  }

  public function methode4($id) //list view icon teacher
  {
    $documents = Document::where('manuel_id', $id)->pluck('pdf');
    $user = auth()->user();
   $userLevelIds = UserLevel::where('teacher_id', $user->id)->pluck('level_id');

    $listmatieree = UserMatiere::where('teacher_id', $user->id)->pluck('matiere_id');
    $matiereNames = [];

    foreach ($listmatieree as $matiereId) {
      
      $matiereName = Material::where('id', $matiereId)->pluck('name')->first();
      if (!is_null($matiereName)) {
          $matiereNames[] = $matiereName;
      }
       }

      $Manuels = Manuels::whereIn('name', $matiereNames)
      ->with([
          'matiere' => function ($query) {
              $query->with(['section' => function ($query) {
                  $query->with('level');
              }]);
          }
      ])->get();
    $pdf->Output('Mathematique1.pdf', 'F');
    $icon = request('icon');
    $page = request('page');
    $video = Video::where('manuel_id', $id)
      ->where('user_id', $user->id)
      ->get();
    $videostitleAll = Video::where('manuel_id', $id)
      ->where('user_id', $user->id)
      ->first();
    $pdfPath = 'Mathematique1.pdf';
    $Manuelsname = Manuels::where('id', $id)->pluck('name');

    return view(getTemplate() . '.panel.Manuel_scolaire.listviewiconteacher', [
      'pageTitle' => 'الكتب المدرسيّة',
      'video' => $video,
      'videostitleAll' => $videostitleAll,
      'Manuels' => $Manuels,
      'id' => $id,
      'icon' => $icon,
      'page' => $page,
      'pdfPath' => $pdfPath,
      'userLevelIds'=>$userLevelIds,
      'matiereNames'=>$matiereNames,
      'manuelsname'=> $Manuelsname,
    ]);
  }

}