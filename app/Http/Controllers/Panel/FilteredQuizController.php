<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\WebinarChapter;
use App\Models\Webinar;
use Illuminate\Http\Request;

class FilteredQuizController extends Controller
{
    /**
     * Récupère les quiz filtrés pour un chapitre spécifique
     */
    public function getFilteredQuizzes(Request $request, $chapterId)
    {
        $user = auth()->user();
        
        if (!$user || !$user->isTeacher()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        // Récupérer le chapitre et le webinar associé
        $chapter = WebinarChapter::findOrFail($chapterId);
        $webinar = $chapter->webinar;
        
        if (!$webinar) {
            return response()->json(['error' => 'Webinar not found'], 404);
        }
        
        // Récupérer les quiz déjà assignés
        $assignedQuiz = Quiz::where('model_id', $chapter->id)->get();
        
        // Construire la requête pour les quiz disponibles
        $availableQuizzesQuery = Quiz::where('status', 'draft')
            ->where('teacher_id', $user->id)
            ->where(function ($query) use ($chapter) {
                $query->whereNull('model_id')
                    ->orWhere('model_id', '!=', $chapter->id);
            });
        
        // Variables de débogage pour comprendre quelles valeurs sont utilisées
        $webinarLevelId = $webinar->level_id ?? null;
        $webinarMaterialId = $webinar->material_id ?? null;
        
        // Filtrer par niveau si disponible
        if ($webinarLevelId) {
            $availableQuizzesQuery->where('level_id', $webinarLevelId);
        }
        
        // Filtrer par matière si disponible
        if ($webinarMaterialId) {
            $availableQuizzesQuery->where('material_id', $webinarMaterialId);
        }
        
        // Récupérer les quiz filtrés
        $availableQuizzes = $availableQuizzesQuery->get();
        
        // Fusionner les quiz disponibles avec ceux déjà assignés
        $allQuizzes = $availableQuizzes->merge($assignedQuiz);
        
        return response()->json([
            'quizzes' => $allQuizzes,
            'webinar' => [
                'id' => $webinar->id,
                'title' => $webinar->title,
                'level_id' => $webinarLevelId,
                'material_id' => $webinarMaterialId
            ],
            'chapter' => [
                'id' => $chapter->id,
                'title' => $chapter->title
            ]
        ]);
    }
}
