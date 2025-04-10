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
 
    // $request->validate([
    //     'pdf' => 'required|mimes:pdf|max:10240',
    //     'num_questions' => 'required|integer|min:1',
       
    // ]);

    $pdf = $request->file('pdf');
    $filename = time() . '-' . $pdf->getClientOriginalName();
    $path = $pdf->move(public_path('uploads'), $filename);

    $fullPath = public_path($path);
 

    // try {
      
        $response = Http::attach(
            'pdf', file_get_contents(public_path('uploads/' . $filename)), $pdf->getClientOriginalName()
        )->post('http://127.0.0.1:8080/generate_quiz', [
            'num_questions' => $request->input('num_questions', 5),
            'lang' => $request->input('lang', 'auto'),
        ]);

        if (!$response->successful()) {
            return back()->withErrors(['error' => 'Erreur lors de la communication avec le service de génération de quiz.']);
        }
  
        $result = $response->json();

        // if (isset($result['error'])) {
        //     return back()->withErrors(['error' => $result['error']]);
        // }

       // DB::beginTransaction();
;
    $quiz = new Quiz();
    $quiz->model_type = null;
    $quiz->model_id = 0;
    $quiz->level_id = $request->input('level');
    $quiz->material_id = $request->input('subject');
    $quiz->question_count = count($result['quiz']); // 
    $quiz->pdf_path = $path;
    $quiz->teacher_id = auth()->id();
    $quiz->save();

        foreach ($result['quiz'] as $questionData) {
            $question = Question::create([
                'quiz_id' => $quiz->id,
                'type' => $questionData['type'] === 'matching' ? 'arrow' : $questionData['type'],
                'question_text' => $questionData['question_text'],
                'score' =>  1, //
                'is_valid' => true,
            ]);

            // foreach ($questionData['answers'] as $answerText => $isValid) {
            //     Answer::create([
            //         'question_id' => $question->id,
            //         'answer_text' => $answerText,
            //         'is_valid' => $isValid,
            //     ]);
            // }
        }

        //DB::commit();

        //session(['quiz' => $result['quiz']]);

        return response()->json(['message'=>'dffffff']); // ou une autre route de ton choix
//view('web.default.panel.quiz.teacher.edit', compact('quizedit'));
    // } catch (\Exception $e) {
    //     DB::rollBack();
    //     \Log::error($e);
    //     return back()->withErrors(['error' => 'Erreur lors de la génération ou de la sauvegarde du quiz : ' . $e->getMessage()]);
    // }
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
