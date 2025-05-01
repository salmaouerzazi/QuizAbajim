<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use Illuminate\Support\Facades\Log;
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
        $quizText = $result['quiz'];
        $language = $result['language'];
        $textContent = $result['text'] ?? '';

        DB::beginTransaction();

        $quiz = new Quiz();
        $quiz->model_type = null;
        $quiz->model_id = 0;
        $quiz->level_id = $request->input('level');
        $quiz->material_id = $request->input('subject');
        $quiz->question_count = $request->input('num_questions', 5);
        $quiz->pdf_path = $path;
        $quiz->teacher_id = auth()->id();
        $quiz->text_content = $textContent; // texte extrait du PDF
        $quiz->created_by = (int) now()->timestamp;
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

        // ✅ Gérer les valeurs techniques directement
        if (in_array($rawType, ['qcm', 'binaire', 'arrow'])) {
            return $rawType;
        }

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
    /**
     * Ajouter une question générée par l'API.
     */
    public function addGeneratedQuestion(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);
        $rawType = $request->input('type');

        // Définir la langue et normaliser le type
        $language = 'arabe';
        $type = $this->normalizeQuestionType($rawType, $language);
        if ($type === 'arrow') {
            // Pour les questions de type Relier : on crée une signature des paires
            $existing_arrows = Question::with('answers')
                ->where('quiz_id', $quiz->id)
                ->where('type', 'arrow')
                ->get()
                ->map(function ($q) {
                    return collect($q->answers)->map(fn($a) => trim($a->answer_text) . '=>' . trim($a->matching))->sort()->implode(';');
                })
                ->toArray();
            $alreadyAsked = implode('|', $existing_arrows);
        } else {
            // Pour QCM et Vrai/Faux : on vérifie juste le texte de la question
            $alreadyAsked = Question::where('quiz_id', $quiz->id)->pluck('question_text')->filter()->implode('|');
        }
        // Appel à l’API Flask
        $response = Http::asForm()->post('http://127.0.0.1:8080/generate_single_question', [
            'text' => $quiz->text_content,
            'type' => $rawType,
            'lang' => $language,
            'already_asked' => $alreadyAsked,
        ]);

        if (!$response->successful()) {
            return response()->json(['success' => false, 'error' => 'Erreur de génération AI']);
        }

        $rawQuestionText = $response->json()['question'] ?? '';
        Log::debug('🧠 Question générée : ' . $rawQuestionText);

        if (!$rawQuestionText) {
            return response()->json(['success' => false, 'error' => 'Réponse vide du modèle.']);
        }

        $questionText = '';
        $answers = [];
        $isValid = null;

        // QCM
        if ($type === 'qcm' && preg_match('/(?:سؤال[:：]?)?\s*(.*?)\s*أ\)\s*(.*?)\s*ب\)\s*(.*?)\s*ج\)\s*(.*?)\s*د\)\s*(.*?)\s*الإجابة الصحيحة[:：]?\s*([أ-ي])/u', $rawQuestionText, $matches)) {
            Log::debug(json_encode($matches, JSON_UNESCAPED_UNICODE));
            $questionText = trim($matches[1]);
            $choices = ['أ' => $matches[2], 'ب' => $matches[3], 'ج' => $matches[4], 'د' => $matches[5]];
            $correct = trim($matches[6]);

            foreach ($choices as $letter => $text) {
                $answers[] = [
                    'answer_text' => $text,
                    'is_valid' => $letter === $correct ? 1 : 0,
                    'matching' => null,
                ];
            }
        }

        // Vrai/Faux
        elseif ($type === 'binaire' && preg_match('/بيان:\s*(.*?)\nالإجابة الصحيحة:\s*(صحيح|خطأ)/u', $rawQuestionText, $matches)) {
            $questionText = trim($matches[1]);
            $correctAnswer = trim($matches[2]);

            $answers[] = ['answer_text' => 'صحيح', 'is_valid' => $correctAnswer === 'صحيح' ? 1 : 0, 'matching' => null];
            $answers[] = ['answer_text' => 'خطأ', 'is_valid' => $correctAnswer === 'خطأ' ? 1 : 0, 'matching' => null];
            $isValid = $correctAnswer === 'صحيح' ? 1 : 0;
        }

        // Rattacher (matching)
        elseif ($type === 'arrow' && preg_match('/العمود أ\s*:\s*(.*?)العمود ب\s*:\s*(.*?)المطابقات\s*:\s*(.*)/us', $rawQuestionText, $matches)) {
            $colA_raw = trim($matches[1]);
            $colB_raw = trim($matches[2]);

            // ✅ Extraire les éléments de la colonne A
            $colA = [];
            if (preg_match_all('/\d+\)\s*(.+)/u', $colA_raw, $matchesA, PREG_SET_ORDER)) {
                foreach ($matchesA as $match) {
                    $colA[] = trim($match[1]);
                }
            }
            // ✅ Extraire les éléments de la colonne B avec leurs lettres
            $colB_map = [];
            if (preg_match_all('/([أ-ي])\)\s*(.+)/u', $colB_raw, $matchesB, PREG_SET_ORDER)) {
                foreach ($matchesB as $match) {
                    $letter = trim($match[1]);
                    $text = trim($match[2]);
                    $colB_map[$letter] = $text;
                }
            }

            // ✅ Nettoyer les flèches et parser les correspondances
            $mapping_raw = str_replace(['→', '➡️', '⇒', '=>', '⟶'], '->', trim($matches[3]));
            $mappings = array_filter(array_map('trim', explode("\n", $mapping_raw)));

            // ✅ Construire les réponses à partir des correspondances
            foreach ($mappings as $line) {
                if (preg_match('/(\d+)\s*->\s*([أ-ي])/u', $line, $link)) {
                    $indexA = (int) $link[1] - 1;
                    $letterB = trim($link[2]);

                    if (isset($colA[$indexA], $colB_map[$letterB])) {
                        $answers[] = [
                            'answer_text' => $colA[$indexA],
                            'is_valid' => null,
                            'matching' => $colB_map[$letterB],
                        ];
                    }
                }
            }

            $questionText = 'اربط العناصر من العمود أ بما يناسبها في العمود ب.';
            Log::debug('🧩 Réponses arrow générées : ' . json_encode($answers, JSON_UNESCAPED_UNICODE));
        }

        // Aucun format reconnu
        else {
            return response()->json(['success' => false, 'error' => 'Format de question non reconnu.']);
        }

        // Sauvegarde en base
        DB::beginTransaction();
        try {
            $question = Question::create([
                'quiz_id' => $quiz->id,
                'type' => $type,
                'question_text' => $questionText,
                'score' => 4,
                'is_valid' => $isValid,
            ]);

            foreach ($answers as $a) {
                Answer::create([
                    'question_id' => $question->id,
                    'answer_text' => $a['answer_text'],
                    'is_valid' => $a['is_valid'],
                    'matching' => $a['matching'],
                ]);
            }

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function updateQuiz(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);
        DB::beginTransaction();

        try {
            // Supprimer les anciennes questions et réponses (facultatif)
            foreach ($quiz->questions as $q) {
                $q->answers()->delete();
                $q->delete();
            }

            foreach ($request->input('questions') as $qIndex => $qData) {
                $type = $qData['type'] ?? 'qcm';
            
                $question = new Question([
                    'quiz_id' => $quiz->id,
                    'type' => $type,
                    'question_text' => $qData['question'] ?? $qData['question_text'],
                    'score' => $qData['score'] ?? 1,
                    'is_valid' => $type === 'binaire' ? ($qData['correct'] === 'true' ? 1 : 0) : null,
                ]);
                $question->save();
            
                // Pour Matching & QCM
                if (!empty($qData['answers'])) {
                    foreach ($qData['answers'] as $i => $a) {
                        $answerText = trim($a['answer_text'] ?? '');
                        if ($answerText === '') continue; // 🛡️ Empêche les réponses vides
            
                        Answer::create([
                            'question_id' => $question->id,
                            'answer_text' => $answerText,
                            'is_valid' => $type === 'qcm' && isset($qData['correct']) && (string)$qData['correct'] === (string)$i ? 1 : 0,
                            'matching' => $a['matching'] ?? null,
                        ]);
                    }
                }
            }
            
            
            DB::commit();
            return redirect()->route('panel.quiz.drafts')->with('success', 'تم حفظ الاختبار في المسودات بنجاح.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e);
            return back()->withErrors(['error' => 'Erreur lors de la mise à jour du quiz.']);
        }
    }
    public function drafts(Request $request)
    {
        $query = Quiz::where('teacher_id', auth()->id())->orderBy('created_by', 'desc');
        if ($request->filled('status')) {
            $query->where('status', $request->status); // 'draft' ou 'published'
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $quizzes = $query->paginate(9);

        if ($request->ajax()) {
            return view('web.default.panel.quiz.teacher.partials.quizzes', compact('quizzes'))->render();
        }

        $teacherLevels = UserMatiere::where('teacher_id', auth()->id())
            ->pluck('level_id')
            ->toArray();
        $levels = School_level::whereIn('id', $teacherLevels)->get();
        $teacherMaterials = UserMatiere::where('teacher_id', auth()->id())
            ->pluck('matiere_id')
            ->toArray();
        $materials = Material::whereIn('id', $teacherMaterials)->get();

        return view('web.default.panel.quiz.teacher.drafts', compact('quizzes', 'levels', 'materials'));
    }

    public function updateTitle(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quiz,id',
            'title' => 'nullable|string|max:255',
        ]);

        $quiz = Quiz::findOrFail($request->quiz_id);
        $quiz->title = $request->title ?: 'تحدي بدون عنوان';
        $quiz->save();

        return response()->json(['success' => true, 'title' => $quiz->title]);
    }

    public function deleteQuestion($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        return response()->json(['success' => true]);
    }
    public function destroy($id)
    {
        $quiz = Quiz::where('teacher_id', auth()->id())->findOrFail($id);

        // Supprimer les questions et réponses associées
        foreach ($quiz->questions as $question) {
            $question->answers()->delete();
            $question->delete();
        }

        $quiz->delete();

        return redirect()->route('panel.quiz.drafts')->with('success', 'تم حذف التحدي بنجاح.');
    }
    public function assignToChapter(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quiz,id',
            'chapter_id' => 'required|exists:webinar_chapters,id',
        ]);

        $quiz = Quiz::findOrFail($request->quiz_id);
        $quiz->model_type = \App\Models\WebinarChapter::class;
        $quiz->model_id = $request->chapter_id;
        $quiz->save();
        return response()->json(['success' => true, 'message' => 'تم ربط الاختبار بالفصل بنجاح.']);

    }
}
