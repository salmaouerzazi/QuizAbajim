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
        $teacherLevels = UserMatiere::where('teacher_id', auth()->id())
            ->pluck('level_id')
            ->toArray();
        $levels = School_level::whereIn('id', $teacherLevels)->get();
        $teacherMaterials = UserMatiere::where('teacher_id', auth()->id())
            ->pluck('matiere_id')
            ->toArray();
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
        $pdf = $request->file('pdf');
        $filename = time() . '-' . $pdf->getClientOriginalName();
        $path = $pdf->move(public_path('uploads'), $filename);

        $fullPath = public_path($path);

        // try {
        $response = Http::attach('pdf', file_get_contents(public_path('uploads/' . $filename)), $pdf->getClientOriginalName())->post('http://127.0.0.1:8080/generate_quiz', [
            'num_questions' => $request->input('num_questions', 5),
            'lang' => $request->input('lang', 'auto'),
        ]);

        if (!$response->successful()) {
            return back()->withErrors(['error' => 'Erreur lors de la communication avec le service de génération de quiz.']);
        }
        $result = $response->json();
        DB::beginTransaction();

        $quiz = new Quiz();
        $quiz->model_type = null;
        $quiz->model_id = 0;
        $quiz->level_id = $request->input('level');
        $quiz->material_id = $request->input('subject');
        $quiz->question_count = $request->input('num_questions', 5);
        $quiz->pdf_path = $path;
        $quiz->teacher_id = auth()->id();
        $quiz->save();

        $quizText = $result['quiz'];
        $language = $result['language'];
        $patterns = config('constants.patterns');
        $questions = [];
        preg_match_all($patterns[$language]['question'], $quizText, $matches, PREG_SET_ORDER);
        preg_match_all($patterns[$language]['question'], $quizText, $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            $type = trim($match[1]);
            $body = trim($match[2]);
            // ----> Question type is true/false
            if (preg_match($patterns[$language]['tf'], $body, $m)) {
                $correct = trim($m[2]);

                $questions[] = [
                    'raw_type' => $type,
                    'type' => 'true_false',
                    'question_text' => trim($m[1]),
                    'correct_answer' => $correct,
                    'answers' => [],
                ];
                // ----> Question type is QCM
            } elseif (preg_match($patterns[$language]['mcq'], $body, $m)) {
                $questionBody = trim($m[1]);
                $correct = trim($m[2]);
                $lines = explode("\n", $questionBody);
                $mainQuestion = array_shift($lines);
                $answers = [];

                foreach ($lines as $line) {
                    if (preg_match('/^([A-Zأ-ي])\)\s*(.*)/u', trim($line), $opt)) {
                        $answers[trim($opt[2])] = trim($opt[1]) === $correct ? true : null;
                    }
                }

                $questions[] = [
                    'raw_type' => $type,
                    'type' => 'multiple_choice',
                    'question_text' => $mainQuestion,
                    'answers' => $answers,
                ];
                // -----> Question type is matching
            } elseif (preg_match($patterns[$language]['match'], $body, $m)) {
                $colA = preg_split('/\d+\)/', trim($m[1]), -1, PREG_SPLIT_NO_EMPTY);

                $colBText = trim($m[2]);

                if ($language === 'arabe') {
                    preg_match_all('/[أ-ي]\)\s*(.+)/u', $colBText, $matchesB);
                } else {
                    preg_match_all('/[a-d]\)\s*(.+)/u', $colBText, $matchesB);
                }

                $colB = $matchesB[1] ?? [];
                $mapping = explode("\n", trim($m[3]));

                $answerRows = [];

                foreach ($mapping as $map) {
                    if (preg_match('/(\d+)\s*→\s*([^\s]+)/u', trim($map), $link)) {
                        $indexA = (int) $link[1] - 1;
                        $indexB = $this->mapLetterToIndex($link[2], $language);

                        $a = isset($colA[$indexA]) ? trim($colA[$indexA]) : null;
                        $b = isset($colB[$indexB]) ? trim($colB[$indexB]) : null;

                        if ($a && $b) {
                            $answerRows[] = [
                                'answer_text' => $a,
                                'matching' => $b,
                            ];
                        }
                    }
                }

                $questions[] = [
                    'raw_type' => $type,
                    'type' => 'matching',
                    'question_text' => 'match_question',
                    'answers' => $answerRows,
                ];
            }
        }

        foreach ($questions as $questionData) {
            $rawType = trim($questionData['raw_type']);
            $parsedType = $this->normalizeQuestionType($rawType, $language);

            $correct = null;
            if ($parsedType === 'binaire' && isset($questionData['correct_answer'])) {
                $correct = in_array(strtolower(trim($questionData['correct_answer'])), ['true', 'vrai', 'صحيح']) ? true : false;
            }

            $question = Question::create([
                'quiz_id' => $quiz->id,
                'type' => $parsedType,
                'question_text' => $questionData['question_text'],
                'score' => 4,
                'is_valid' => $parsedType === 'binaire' ? $correct : null,
            ]);

            if ($parsedType === 'qcm') {
                foreach ($questionData['answers'] as $answerText => $isValid) {
                    Answer::create([
                        'question_id' => $question->id,
                        'answer_text' => $answerText,
                        'is_valid' => $isValid === true ? true : false,
                        'matching' => null,
                    ]);
                }
            } elseif ($parsedType === 'arrow') {
                foreach ($questionData['answers'] as $answerRow) {
                    Answer::create([
                        'question_id' => $question->id,
                        'answer_text' => $answerRow['answer_text'],
                        'is_valid' => null,
                        'matching' => $answerRow['matching'],
                    ]);
                }
            }
        }

        DB::commit();

        return redirect()->route('panel.quiz.edit', ['id' => $quiz->id]);
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     \Log::error($e);
        //     return back()->withErrors(['error' => 'Erreur lors de la génération ou de la sauvegarde du quiz : ' . $e->getMessage()]);
        // }
    }
    private function normalizeQuestionType(string $rawType, string $lang): string
    {
        $rawType = trim(mb_strtolower($rawType));

        $map = [
            'arabe' => [
                'ربط' => 'arrow',
                'صحيح/خطأ' => 'binaire',
                'اختيار من متعدد' => 'qcm',
            ],
            'français' => [
                'relier' => 'arrow',
                'vrai/faux' => 'binaire',
                'qcm' => 'qcm',
            ],
            'anglais' => [
                'matching' => 'arrow',
                'true/false' => 'binaire',
                'multiple choice' => 'qcm',
            ],
        ];

        foreach ($map[$lang] ?? [] as $label => $type) {
            if (mb_strpos($rawType, $label) !== false) {
                return $type;
            }
        }

        return 'qcm'; // fallback par défaut
    }
    private function mapLetterToIndex(string $letter, string $language): ?int
    {
        $letter = trim($letter);

        if ($language === 'arabe') {
            $arabicMap = ['أ' => 0, 'ب' => 1, 'ج' => 2];
            return $arabicMap[$letter] ?? null;
        }

        if (in_array($language, ['français', 'anglais'])) {
            $letter = strtolower($letter);
            $map = ['a' => 0, 'b' => 1, 'c' => 2];
            return $map[$letter] ?? null;
        }

        return null;
    }

    /**
     * Afficher la page d'édition des questions générées.
     */
    public function editQuiz($id)
    {
        $quiz = Quiz::findOrFail($id);
        $questions = Question::where('quiz_id', $quiz->id)->get();
        $answers = Answer::whereIn('question_id', $questions->pluck('id'))->get();


        $data = [
            'quiz' => $quiz,
            'questions' => $questions,
            'answers' => $answers,
        ];

        return view('web.default.panel.quiz.teacher.edit', $data);
    }
}
