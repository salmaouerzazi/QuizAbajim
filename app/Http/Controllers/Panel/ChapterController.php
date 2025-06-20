<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Quiz;
use App\Models\Session;
use App\Models\TextLesson;
use App\Models\Translation\WebinarChapterTranslation;
use App\Models\Webinar;
use App\Models\WebinarAssignment;
use App\Models\WebinarChapter;
use App\Models\WebinarChapterItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Mixins\RegistrationPackage\UserPackage;
use App\Models\Translation\WebinarTranslation;


class ChapterController extends Controller
{
    public function getChapter(Request $request, $id)
    {
        $user = auth()->user();

        $chapter = WebinarChapter::where('id', $id)
            ->where('user_id', $user->id)
            ->first();
        
        // Récupérer le webinar associé au chapitre pour obtenir le niveau et la matière
        $webinar = $chapter->webinar;
        
        // Débogage - Vérifier les valeurs des champs webinar
        $debug = [
            'webinar_id' => $webinar->id,
            'webinar_title' => $webinar->title,
            'level_id' => $webinar->level_id,
            'material_id' => $webinar->material_id,
            'chapter_id' => $chapter->id
        ];
        
        // Filtrer les quiz déjà assignés à ce chapitre
        $assignedQuiz = Quiz::where('model_id', $chapter->id)
            ->get();
            
        // Filtrer les quiz non assignés selon le niveau et la matière du webinar
        $availableQuizzes = Quiz::where('status', 'draft')
            ->where(function ($query) use ($chapter) {
                $query->whereNull('model_id')
                    ->orWhere('model_id', '!=', $chapter->id);
            })
            ->where('teacher_id', $user->id);
            
        // Appliquer le filtrage par niveau et matière si ces données sont disponibles dans le webinar
        if (!empty($webinar->level_id)) {
            $availableQuizzes->where('level_id', $webinar->level_id);
        }
        
        // Utiliser material_id pour la matière dans les deux modèles
        if (!empty($webinar->material_id)) {
            $availableQuizzes->where('material_id', $webinar->material_id);
        }
        
        // Avant d'exécuter la requête, récupérons tous les quiz pour débogage
        $allQuizzes = Quiz::where('status', 'draft')
            ->where('teacher_id', $user->id)
            ->get();
            
        // Tableau pour débogage - Tous les quiz
        $quizDebug = [];
        foreach ($allQuizzes as $quiz) {
            $quizDebug[] = [
                'id' => $quiz->id,
                'title' => $quiz->title,
                'level_id' => $quiz->level_id,
                'material_id' => $quiz->material_id,
                'webinar_level_id' => $webinar->level_id,
                'webinar_material_id' => $webinar->material_id,
                'level_match' => ($quiz->level_id == $webinar->level_id),
                'material_match' => ($quiz->material_id == $webinar->material_id),
                'would_be_filtered' => ($quiz->level_id == $webinar->level_id && $quiz->material_id == $webinar->material_id)
            ];
        }
        
        // Enregistrer les résultats de débogage dans le fichier de log
        \Log::info('Debug Webinar et Quiz filtering', [
            'webinar' => $debug,
            'quizzes' => $quizDebug
        ]);
        
        $availableQuizzes = $availableQuizzes->get();
        
        // Combiner les quizzes disponibles avec les quizzes déjà assignés
        $quizzes = $availableQuizzes->merge($assignedQuiz);
        
        $locale = $request->get('locale', app()->getLocale());

        if (!empty($chapter)) {
            foreach ($chapter->translatedAttributes as $attribute) {
                try {
                    $chapter->$attribute = $chapter->translate(mb_strtolower($locale))->$attribute;
                } catch (\Exception $e) {
                    $chapter->$attribute = null;
                }
            }

            $data = [
                'chapter' => $chapter,
                'quiz' => $assignedQuiz,  // Quiz déjà assignés au chapitre
                'quizzes' => $quizzes,    // Tous les quiz disponibles pour l'assignation
                'debug' => $debug,        // Informations sur le webinar
                'quizDebug' => $quizDebug // Informations sur tous les quiz
            ];

            return response()->json($data, 200);
        }

        abort(403);
    }

    public function getAllByWebinarId($webinar_id)
    {
        $user = auth()->user();

        $webinar = Webinar::find($webinar_id);

        if (!empty($webinar) and $webinar->canAccess($user)) {

            $chapters = $webinar->chapters->where('status', WebinarChapter::$chapterActive);

            $data = [
                'chapters' => [],
            ];

            if (!empty($chapters) and count($chapters)) {
                // for translate send on array of data

                foreach ($chapters as $chapter) {
                    $data['chapters'][] = [
                        'user_id' => $chapter->user_id,
                        'webinar_id' => $chapter->webinar_id,
                        'id' => $chapter->id,
                        'order' => $chapter->order,
                        'status' => $chapter->status,
                        'title' => $chapter->title,
                        'type' => $chapter->type,
                        'created_at' => $chapter->created_at,
                    ];
                }
            }

            return response()->json($data, 200);
        }

        abort(403);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $data = $request->get('ajax')['chapter'];

        $validator = Validator::make($data, [
            'webinar_id' => 'required',
            'title' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response([
                'code' => 422,
                'errors' => $validator->errors(),
            ], 422);
        }

        $webinar = Webinar::find($data['webinar_id']);
                

        if (!empty($webinar) and $webinar->canAccess($user)) {
            $status = WebinarChapter::$chapterInactive;

            $chapter = WebinarChapter::create([
                'user_id' => $user->id,
                'webinar_id' => $webinar->id,
                'status' => $status,
                'check_all_contents_pass' => (!empty($data['check_all_contents_pass']) and $data['check_all_contents_pass'] == 'on'),
                'created_at' => time(),
            ]);

            if (!empty($chapter)) {
                WebinarChapterTranslation::updateOrCreate([
                    'webinar_chapter_id' => $chapter->id,
                    'locale' => mb_strtolower($data['locale']),
                ], [
                    'title' => $data['title'],
                ]);
            }

            return response()->json([
                'code' => 200,
            ], 200);
        }

        abort(403);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();

        $chapter = WebinarChapter::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!empty($chapter)) {
            $data = $request->get('ajax')['chapter'];

            $validator = Validator::make($data, [
                'webinar_id' => 'required',
                'title' => 'required|max:255',
            ]);

            if ($validator->fails()) {
                return response([
                    'code' => 422,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $status = (!empty($data['status']) and $data['status'] == 'on') ? WebinarChapter::$chapterActive : WebinarChapter::$chapterInactive;

            $chapter->update([
                'status' => $status,
                'check_all_contents_pass' => (!empty($data['check_all_contents_pass']) and $data['check_all_contents_pass'] == 'on'),
            ]);

            WebinarChapterTranslation::updateOrCreate([
                'webinar_chapter_id' => $chapter->id,
                'locale' => mb_strtolower($data['locale']),
            ], [
                'title' => $data['title'],
            ]);

            return response()->json([
                'code' => 200
            ], 200);
        }

        abort(403);
    }

    public function destroy($id)
    {
        $user = auth()->user();

        $chapter = WebinarChapter::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!empty($chapter)) {
            $chapter->delete();

            return response()->json([
                'code' => 200
            ], 200);
        }

        abort(403);
    }

    public function change(Request $request)
    {
        $user = auth()->user();
        $data = $request->get('ajax');

        $validator = Validator::make($data, [
            'item_id' => 'required',
            'item_type' => 'required',
            'chapter_id' => 'required',
            'webinar_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'code' => 422,
                'errors' => $validator->errors(),
            ], 422);
        }

        $item = null;

        $webinar = Webinar::find($data['webinar_id']);

        if (!empty($webinar) and $webinar->canAccess($user)) {

            switch ($data['item_type']) {
                case WebinarChapterItem::$chapterSession:
                    $item = Session::where('id', $data['item_id'])
                        ->where('webinar_id', $data['webinar_id'])
                        ->first();
                    break;

                case WebinarChapterItem::$chapterFile:
                    $item = File::where('id', $data['item_id'])
                        ->where('webinar_id', $data['webinar_id'])
                        ->first();
                    break;

                case WebinarChapterItem::$chapterTextLesson:
                    $item = TextLesson::where('id', $data['item_id'])
                        ->where('webinar_id', $data['webinar_id'])
                        ->first();
                    break;

                case WebinarChapterItem::$chapterQuiz:
                    $item = Quiz::where('id', $data['item_id'])
                       
                        ->first();
                    break;

                case WebinarChapterItem::$chapterAssignment:
                    $item = WebinarAssignment::where('id', $data['item_id'])
                        ->where('webinar_id', $data['webinar_id'])
                        ->first();
                    break;
            }
        }

        if (!empty($item)) {
            $item->update([
                'chapter_id' => !empty($data['chapter_id']) ? $data['chapter_id'] : null
            ]);

            WebinarChapterItem::where('item_id', $item->id)
                ->where('type', $data['item_type'])
                ->delete();

            if (!empty($data['chapter_id'])) {
                WebinarChapterItem::makeItem($user->id, $data['chapter_id'], $item->id, $data['item_type']);
            }
        }

        return response()->json([
            'code' => 200
        ], 200);
    }
}
