<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Question;    
use App\Models\Answer;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\UserMatiere;
use App\Models\School_level;
use App\Models\Material;

class QuizController extends Controller 
{
    public function indexQuiz()
    {
        $teacherLevels = UserMatiere::where('teacher_id', auth()->id())->pluck('level_id')->toArray();
        $levels = School_level::whereIn('id', $teacherLevels)->get();
        $teacherMaterials = UserMatiere::where('teacher_id', auth()->id())->pluck('matiere_id')->toArray();
        $materials = Material::whereIn('id', $teacherMaterials)->get();
        $data = [
            'levels' => $levels,
            'materials' => $materials,
        ];
        return view('web.default.panel.quiz.teacher.index', $data);
    }

    /**
     * Générer le quiz en utilisant le modèle Python.
     */
    public function generate(Request $request)
{
    $request->validate([
        'pdf' => 'required|mimes:pdf|max:10240',
        'num_questions' => 'required|integer|min:1',
       
    ]);

    $pdf = $request->file('pdf');
    $filename = time() . '-' . $pdf->getClientOriginalName();
    $path = $pdf->storeAs('uploads', $filename);
    $fullPath = storage_path('app/' . $path);

    try {
        $response = Http::attach(
            'pdf', file_get_contents($fullPath), $pdf->getClientOriginalName()
        )->post('http://127.0.0.1:8080/generate_quiz', [
            'num_questions' => $request->input('num_questions', 5),
            'lang' => $request->input('lang', 'auto'),
        ]);

        $result = $response->json();

        if (isset($result['error'])) {
            return back()->withErrors(['error' => $result['error']]);
        }

        DB::beginTransaction();

        $quiz = Quiz::create([
            'model_type' => null,
            'model_id' => null,
            'level_id' => $request->input('level'),
            'material_id' => $request->input('subject', null),
            'question_count' => count($result['quiz']),
            'pdf_path' => $path,
            'teacher_id' => auth()->id(),
            'created_by' => auth()->id(),
        ]);

        foreach ($result['quiz'] as $questionData) {
            $question = Question::create([
                'quiz_id' => $quiz->id,
                'type' => $questionData['type'],
                'question_text' => $questionData['question_text'],
                'score' => $questionData['score'],
                'is_valid' => true,
            ]);

            foreach ($questionData['answers'] as $answerText => $isValid) {
                Answer::create([
                    'question_id' => $question->id,
                    'answer_text' => $answerText,
                    'is_valid' => $isValid,
                ]);
            }
        }

        DB::commit();

        session(['quiz' => $result['quiz']]);

        return redirect()->route('panel.quiz.edit'); // ou une autre route de ton choix

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error($e);
        return back()->withErrors(['error' => 'Erreur lors de la génération ou de la sauvegarde du quiz : ' . $e->getMessage()]);
    }
}

    /**
     * Afficher la page d'édition des questions générées.
     */
    public function editQuiz()
    {
        $quiz = session('quiz');
        return view('web.default.panel.quiz.teacher.edit', compact('quiz'));

    }
}
