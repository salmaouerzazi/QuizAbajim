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
use App\Models\QuizSubmissions;
use App\Models\QuizAttemptScore;

use App\User;

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
        $quiz->title = $request->input('title', 'تحدي بدون عنوان');
        $quiz->status = 'draft';
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
        $quiz->load(['teacher', 'material']);

        // $children = User::where('role_name', 'enfant')->where('level_id', $quiz->level_id)->get();

        // if ($children) {
        //     foreach ($children as $child) {
        //         $child->notify(new \App\Notifications\NewQuizNotification($quiz));
        //     }
        // }

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

            //  Extraire les éléments de la colonne A
            $colA = [];
            if (preg_match_all('/\d+\)\s*(.+)/u', $colA_raw, $matchesA, PREG_SET_ORDER)) {
                foreach ($matchesA as $match) {
                    $colA[] = trim($match[1]);
                }
            }
            //  Extraire les éléments de la colonne B avec leurs lettres
            $colB_map = [];
            if (preg_match_all('/([أ-ي])\)\s*(.+)/u', $colB_raw, $matchesB, PREG_SET_ORDER)) {
                foreach ($matchesB as $match) {
                    $letter = trim($match[1]);
                    $text = trim($match[2]);
                    $colB_map[$letter] = $text;
                }
            }

            //  Nettoyer les flèches et parser les correspondances
            $mapping_raw = str_replace(['→', '➡️', '⇒', '=>', '⟶'], '->', trim($matches[3]));
            $mappings = array_filter(array_map('trim', explode("\n", $mapping_raw)));

            //  Construire les réponses à partir des correspondances
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
                        if ($answerText === '') {
                            continue;
                        } //  Empêche les réponses vides

                        Answer::create([
                            'question_id' => $question->id,
                            'answer_text' => $answerText,
                            'is_valid' => $type === 'qcm' && isset($qData['correct']) && (string) $qData['correct'] === (string) $i ? 1 : 0,
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
        // Log tous les paramètres de requête pour débogage
        \Log::info('Paramètres de filtrage reçus:', $request->all());
        
        $query = Quiz::where('teacher_id', auth()->id())->orderBy('created_by', 'desc');
        
        // Filtrer par statut
        if ($request->filled('status')) {
            $query->where('status', $request->status);
            \Log::info('Filtrage par statut:', ['status' => $request->status]);
        }
        
        // Filtrer par niveau
        if ($request->filled('level')) {
            $query->whereHas('level', function($q) use ($request) {
                $q->where('name', $request->level);
            });
            \Log::info('Filtrage par niveau:', ['level' => $request->level]);
        }
        
        // Filtrer par matière
        if ($request->filled('material')) {
            $query->whereHas('material', function($q) use ($request) {
                $q->where('name', $request->material);
            });
            \Log::info('Filtrage par matière:', ['material' => $request->material]);
        }
        
        // Recherche par titre
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
            \Log::info('Recherche par titre:', ['search' => $request->search]);
        }
        
        // Utiliser withQueryString pour préserver les paramètres dans les liens de pagination
        $quizzes = $query->paginate(9)->withQueryString();

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
    
    /**
     * Mettre à jour l'ordre des questions d'un quiz
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quiz,id',
            'question_order' => 'required|array',
            'question_order.*' => 'required|exists:quiz_questions,id'
        ]);
        
        try {
            // Récupérer le quiz
            $quiz = Quiz::findOrFail($request->quiz_id);
            
            // Mettre à jour l'ordre de chaque question
            foreach ($request->question_order as $index => $questionId) {
                \DB::table('quiz_questions')
                    ->where('id', $questionId)
                    ->where('quiz_id', $quiz->id)
                    ->update(['order' => $index + 1]);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'تم تحديث ترتيب الأسئلة بنجاح'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تحديث ترتيب الأسئلة',
                'error' => $e->getMessage()
            ], 500);
        }
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
        try {
            $request->validate([
                'quiz_id' => 'required|exists:quiz,id',
                'chapter_id' => 'required|exists:webinar_chapters,id',
            ]);

            $quiz = Quiz::findOrFail($request->quiz_id);
            $chapter = \App\Models\WebinarChapter::findOrFail($request->chapter_id);
            $webinar = $chapter->webinar;
            
            // Vérification de compatibilité niveau et matière
            $compatible = true;
            $message = '';
            
            // Vérifier la compatibilité du niveau
            if (!empty($webinar->level_id) && !empty($quiz->level_id) && $webinar->level_id != $quiz->level_id) {
                $compatible = false;
                $webinarLevel = \App\Models\School_level::find($webinar->level_id);
                $quizLevel = \App\Models\School_level::find($quiz->level_id);
                $message = 'المستوى غير متطابق: الفصل (' . ($webinarLevel ? $webinarLevel->name : 'غير معروف') . ') والتحدي (' . ($quizLevel ? $quizLevel->name : 'غير معروف') . ')';
            }
            
            // Vérifier la compatibilité de la matière (matiere_id dans Webinar, material_id dans Quiz)
            if ($compatible && !empty($webinar->matiere_id) && !empty($quiz->material_id) && $webinar->matiere_id != $quiz->material_id) {
                $compatible = false;
                $webinarMaterial = \App\Models\Material::find($webinar->matiere_id);
                $quizMaterial = \App\Models\Material::find($quiz->material_id);
                $message = 'المادة غير متطابقة: الفصل (' . ($webinarMaterial ? $webinarMaterial->name : 'غير معروف') . ') والتحدي (' . ($quizMaterial ? $quizMaterial->name : 'غير معروف') . ')';
            }
            
            // Si non compatible, retourner une erreur
            if (!$compatible) {
                return response()->json(['success' => false, 'message' => $message], 422);
            }
            
            // Si compatible, poursuivre l'assignation
            $quiz->model_type = 'App\\Models\\WebinarChapter';
            $quiz->model_id = $request->chapter_id;
            $quiz->status = 'published';
            $quiz->save();

            //  Créer une notification principale
            try {
                $chapter = \App\Models\WebinarChapter::find($request->chapter_id);
                if ($chapter) {
                    $notification = new \App\QuizNotification();
                    $notification->title = 'هل أنت جاهز للتحدي؟';
                    $notification->message = '🔥 اختبار جديد "' . $quiz->title . '" في الفصل "' . $chapter->title . '" بانتظارك! أظهر قوتك وأبهر الجميع بنتيجتك! 🏆';
                    $notification->quiz_id = $quiz->id;
                    $notification->sender_type = 'admin';
                    $notification->sender_id = auth()->id();
                    $notification->target_type = 'multiple';
                   
                    $notification->save();

                    \Log::info('Notification créée: ' . $notification->id);

                    // Créer des notifications pour chaque enfant dans le système
                    try {
                        $children = DB::select("SELECT id FROM users WHERE role_name = 'enfant'");
                        $childrenCount = count($children);
                        \Log::info('Nombre d\'enfants trouvés (SQL brut): ' . $childrenCount);
                    } catch (\Exception $e) {
                        \Log::error('Erreur lors de la récupération des enfants: ' . $e->getMessage());
                        $children = [];
                    }

                    try {
                        $tableInfo = DB::select('SHOW COLUMNS FROM quiz_notifications_users');
                        \Log::info('Structure de la table quiz_notifications_users: ' . json_encode($tableInfo));
                    } catch (\Exception $e) {
                        \Log::error('Erreur lors de la vérification de la structure de la table: ' . $e->getMessage());
                    }

                    foreach ($children as $child) {
                        $childId = $child->id;
                        \Log::info('Traitement de l\'enfant ID: ' . $childId);

                        try {
                            // Méthode directe - Insert dans la base de données
                            DB::statement(
                                "INSERT INTO quiz_notifications_users
                                 (notification_id, receiver_id, is_read, created_at, updated_at)
                                 VALUES (?, ?, ?, ?, ?)",
                                [$notification->id, $childId, 0, now(), now()],
                            );
                            \Log::info('Notification utilisateur créée pour enfant ' . $childId . ' avec DB::statement');
                        } catch (\Exception $e) {
                            \Log::error('Erreur lors de la création de notification (DB::statement): ' . $e->getMessage());

                            try {
                                $insertSQL = "INSERT INTO quiz_notifications_users
                                             (notification_id, receiver_id, is_read, created_at, updated_at)
                                             VALUES ({$notification->id}, {$childId}, 0, NOW(), NOW())";
                                DB::unprepared($insertSQL);
                                \Log::info('Notification utilisateur créée pour enfant ' . $childId . ' avec DB::unprepared');
                            } catch (\Exception $e2) {
                                \Log::error('Erreur lors de la création de notification (DB::unprepared): ' . $e2->getMessage());
                            }
                        }
                    }
                }
            } catch (\Exception $notifError) {
                // Log l'erreur mais ne pas bloquer l'assignation
                \Log::error('Erreur création notification: ' . $notifError->getMessage());
            }

            return response()->json(['success' => true, 'message' => 'تم ربط الاختبار بالفصل بنجاح.']);
        } catch (\Exception $e) {
            \Log::error('Erreur assignToChapter: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()], 500);
        }
    }
    public function delete(Request $request)
    {
        $quiz = \App\Models\Quiz::findOrFail($request->quiz_id);

        $quiz->model_type = null;
        $quiz->model_id = null;

        $quiz->status = 'draft';

        $quiz->save();

        return back()->with('success', 'تم إلغاء ربط التحدي بنجاح.');
    }
    public function showForChild($id)
    {
        $quiz = Quiz::with('questions.answers')->findOrFail($id);

        $chapter = \App\Models\WebinarChapter::where('id', $quiz->model_id)->first();
        $course = $chapter ? $chapter->webinar : null;

        return view('web.default.panel.quiz.child.doQuiz', compact('quiz', 'course'));
    }
    public function submitFromChild(Request $request, $id)
    {
        $quiz = Quiz::with('questions.answers')->findOrFail($id);
        $childId = auth()->id();
        $answers = $request->input('answers', []);

        $lastAttempt = QuizAttemptScore::where('quiz_id', $quiz->id)->where('child_id', $childId)->orderByDesc('attempt_number')->first();

        $attemptNumber = $lastAttempt ? $lastAttempt->attempt_number + 1 : 1;

        $totalScore = $quiz->questions->sum('score');

        $attempt = QuizAttemptScore::create([
            'quiz_id' => $quiz->id,
            'child_id' => $childId,
            'attempt_number' => $attemptNumber,
            'score' => 0, // temporaire
            'score_total' => $totalScore,
            'submitted_at' => now(),
        ]);

        $score = 0;

        foreach ($quiz->questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;
            $isValid = false;

            if ($question->type === 'binaire') {
                $expected = $question->is_valid ? 'true' : 'false';
                $isValid = $userAnswer === $expected;

                QuizSubmissions::create([
                    'quiz_id' => $quiz->id,
                    'child_id' => $childId,
                    'attempt_id' => $attempt->id,
                    'question_id' => $question->id,
                    'is_valid' => $isValid,
                    'is_boolean_question' => true,
                ]);
            } elseif ($question->type === 'qcm') {
                $expectedId = $question->answers->where('is_valid', true)->first()?->id;
                $isValid = $userAnswer == $expectedId;

                QuizSubmissions::create([
                    'quiz_id' => $quiz->id,
                    'child_id' => $childId,
                    'attempt_id' => $attempt->id,
                    'question_id' => $question->id,
                    'answer_id' => $userAnswer,
                    'is_valid' => $isValid,
                    'is_boolean_question' => false,
                ]);
            } elseif ($question->type === 'arrow') {
                $expectedMap = $question->answers->mapWithKeys(fn($a) => [$a->answer_text => $a->matching])->toArray();
                $userMap = is_string($userAnswer) ? json_decode($userAnswer, true) : $userAnswer ?? [];
                $isValid = $userMap == $expectedMap;

                QuizSubmissions::create([
                    'quiz_id' => $quiz->id,
                    'child_id' => $childId,
                    'attempt_id' => $attempt->id,
                    'question_id' => $question->id,
                    'arrow_mapping' => json_encode($userMap),
                    'is_valid' => $isValid,
                    'is_boolean_question' => false,
                ]);
            }

            if ($isValid) {
                $score += $question->score;
            }
        }

        $attempt->update(['score' => $score]);

        return view('web.default.panel.quiz.child.result', [
            'quiz' => $quiz,
            'attempt' => $attempt,
            'submissions' => $attempt->submissions()->with('question', 'question.answers')->get(),
        ]);
    }
    public function storeAttempt(Request $request, $quiz_id)
    {
        $quiz = Quiz::with('questions.answers')->findOrFail($quiz_id);
        $childId = auth()->id();
        $submittedAnswers = $request->input('answers', []);

        $score = 0;
        $score_total = $quiz->questions->sum('score');

        $attempt = QuizAttemptScore::create([
            'quiz_id' => $quiz->id,
            'child_id' => $childId,
            'score' => 0, 
            'score_total' => $score_total,
            'submitted_at' => now(),
        ]);

        foreach ($quiz->questions as $question) {
            $qId = $question->id;
            $userAnswer = $submittedAnswers[$qId] ?? null;

            if ($question->type === 'qcm' && $userAnswer) {
                $answer = Answer::find($userAnswer);
                $isCorrect = $answer?->is_valid == 1;

                QuizSubmissions::create([
                    'quiz_id' => $quiz->id,
                    'child_id' => $childId,
                    'attempt_id' => $attempt->id,
                    'question_id' => $qId,
                    'answer_id' => $answer?->id,
                    'is_valid' => $isCorrect,
                    'is_boolean_question' => false,
                ]);

                if ($isCorrect) {
                    $score += $question->score;
                }
            }

            elseif ($question->type === 'binaire' && $userAnswer !== null) {
                $expected = $question->is_valid ? 'true' : 'false';
                $isCorrect = $userAnswer === $expected;

                QuizSubmissions::create([
                    'quiz_id' => $quiz->id,
                    'child_id' => $childId,
                    'attempt_id' => $attempt->id,
                    'question_id' => $qId,
                    'answer_id' => null,
                    'is_valid' => $isCorrect,
                    'is_boolean_question' => true,
                ]);

                if ($isCorrect) {
                    $score += $question->score;
                }
            }

            elseif ($question->type === 'arrow' && is_array($userAnswer)) {
                $correctPairs = $question->answers
                    ->mapWithKeys(function ($a) {
                        return [$a->answer_text => $a->matching];
                    })
                    ->toArray();

                $isCorrect = true;
                foreach ($correctPairs as $source => $target) {
                    if (($userAnswer[$source] ?? null) !== $target) {
                        $isCorrect = false;
                        break;
                    }
                }

                QuizSubmissions::create([
                    'quiz_id' => $quiz->id,
                    'child_id' => $childId,
                    'attempt_id' => $attempt->id,
                    'question_id' => $qId,
                    'answer_id' => null,
                    'is_valid' => $isCorrect,
                    'arrow_mapping' => $userAnswer,
                    'is_boolean_question' => false,
                ]);

                if ($isCorrect) {
                    $score += $question->score;
                }
            }
        }

        $attempt->update(['score' => $score]);

        //  Récupération des réponses pour l'affichage
        $submissions = QuizSubmissions::with('question', 'answer')->where('attempt_id', $attempt->id)->get();

        return view('web.default.panel.quiz.child.result', [
            'quiz' => $quiz,
            'attempt' => $attempt,
            'submissions' => $submissions,
        ]);
    }
}
