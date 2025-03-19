<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\CartManagerController;
use App\Models\Reward;
use App\Models\RewardAccounting;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Jenssegers\Agent\Agent; // Detect user device

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/panel';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $seoSettings = getSeoMetas('login');
        $pageTitle = !empty($seoSettings['title']) ? $seoSettings['title'] : trans('site.login_page_title');
        $pageDescription = !empty($seoSettings['description']) ? $seoSettings['description'] : trans('site.login_page_title');
        $pageRobot = getPageRobot('login');

        $data = [
            'pageTitle' => $pageTitle,
            'pageDescription' => $pageDescription,
            'pageRobot' => $pageRobot,
        ];

        return view(getTemplate() . '.auth.login', $data);
    }

    public function login(Request $request)
    {
        $rules = [
            'username' => 'required|numeric',
            'password' => 'required|min:6',
        ];

        if ($this->username() == 'email') {
            $rules['username'] = 'required|email';
        }

        $this->validate($request, $rules);

        if ($this->attemptLogin($request)) {
            return $this->afterLogged($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function username()
    {
        $email_regex = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i";

        if (empty($this->username)) {
            $this->username = 'mobile';
            if (preg_match($email_regex, request('username', null))) {
                $this->username = 'email';
            }
        }
        return $this->username;
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = [
            $this->username() => $request->get('username'),
            'password' => $request->get('password')
        ];
        $remember = true;

        /*if (!empty($request->get('remember')) and $request->get('remember') == true) {
            $remember = true;
        }*/

        return $this->guard()->attempt($credentials, $remember);
    }

    public function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'username' => [trans('validation.password_or_username')],
        ]);
    }

    protected function sendBanResponse($user)
    {
        throw ValidationException::withMessages([
            'username' => [trans('auth.ban_msg', ['date' => dateTimeFormat($user->ban_end_at, 'j M Y')])],
        ]);
    }

    protected function sendNotActiveResponse($user)
    {
        $toastData = [
            'title' => trans('public.request_failed'),
            'msg' => trans('auth.login_failed_your_account_is_not_verified'),
            'status' => 'error'
        ];

        return redirect('/login')->with(['toast' => $toastData]);
    }

    public function afterLogged(Request $request, $verify = false)
    {
        $user = auth()->user();

        if ($user->ban) {
            $time = time();
            $endBan = $user->ban_end_at;
            if (!empty($endBan) and $endBan > $time) {
                $this->guard()->logout();
                $request->session()->flush();
                $request->session()->regenerate();

                return $this->sendBanResponse($user);
            } elseif (!empty($endBan) and $endBan < $time) {
                $user->update([
                    'ban' => false,
                    'ban_start_at' => null,
                    'ban_end_at' => null,
                ]);
            }
        }

        if ($user->status != User::$active and !$verify) {
            if ($user) {
                $loginTime = session('login_time'); // Retrieve stored login time
                if ($loginTime) {
                    // Calculate the number of minutes the user spent online
                    $minutesSpent = Carbon::parse($loginTime)->diffInMinutes(Carbon::now('Africa/Tunis'));
        
                    // Increment the user's total online time
                    $user->increment('online_time', $minutesSpent);
                }
            }

            $this->guard()->logout();
            $request->session()->flush();
            $request->session()->regenerate();

            $verificationController = new VerificationController();
            $checkConfirmed = $verificationController->checkConfirmed($user, $this->username(), $request->get('username'));

            if ($checkConfirmed['status'] == 'send') {
                return redirect('/verification');
            }
        } elseif ($verify) {
            session()->forget('verificationId');

            $user->update([
                'status' => User::$active,
            ]);

            $registerReward = RewardAccounting::calculateScore(Reward::REGISTER);
            RewardAccounting::makeRewardAccounting($user->id, $registerReward, Reward::REGISTER, $user->id, true);
        }
 
        if ($user->status != User::$active) {
            $this->guard()->logout();
            $request->session()->flush();
            $request->session()->regenerate();

            return $this->sendNotActiveResponse($user);
        }
        // 1. Track First Login Time
    if (is_null($user->first_login_at)) {
       
        $user->update(['first_login_at' => Carbon::now('Africa/Tunis')]);
      

    }

    // 2. Track Last Seen (User Online)
    $user->update(['last_seen_at' => Carbon::now('Africa/Tunis')]);
    session(['login_time' => Carbon::now('Africa/Tunis')]); // Store login time in session

    // 3. Detect Device Type
    $agent = new Agent();
    $deviceType = 'computer';
    if ($agent->isMobile()) {
        $deviceType = 'android';
        if ($agent->is('iPhone')) {
            $deviceType = 'iOS';
        }
    }
    $user->update(['device_type' => $deviceType]);
        $cartManagerController = new CartManagerController();
        $cartManagerController->storeCookieCartsToDB();

        if ($user->isAdmin()) {
            return redirect('/admin');
        }
        elseif($user->isOrganization())
        {
            $parentId = User::where('id', $user->id)->pluck('id')->first();
            $enfantCount = User::where('organ_id', $parentId)->count();
            $firstChild = User::where('organ_id', $parentId)->first();

            if ($enfantCount >= 1 )
            {
                app('App\Http\Controllers\Panel\UserController')->impersonate($firstChild->id);
            }
            return redirect()->route('panel.dashboard.enfant');
        }
        elseif(empty($user->section_id)){
            if($user->isUser()){
                return redirect('/step2');
                
            }
            else{
                if(empty($user->matier_id)){
                return redirect()->route('becomeInstructor');
                }else {

                    return redirect()->route('panel.dashboard');
                }
            }
            
        }
        else {

            return redirect()->route('panel.dashboard');
        }

   
    }
}
