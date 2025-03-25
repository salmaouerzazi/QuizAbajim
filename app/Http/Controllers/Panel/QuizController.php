<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Affiche la page principale de création de quiz (drag & drop).
     */
    public function indexQuiz()
    {
        return view('web.default.panel.quiz.teacher.index');
    }

    /**
     * Gère la soumission du formulaire avec fichier PDF.
     */
    public function generateQuiz(Request $request)
    {
        // ✅ Validation du formulaire
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:10240',
            'subject' => 'required|string',
            'level' => 'required|string',
            'question_count' => 'required|integer|min:1',
        ]);

        // 📥 Récupération du fichier PDF
        $pdf = $request->file('pdf');

        // 🗂️ Sauvegarde du fichier temporairement dans storage/app/public/quizzes
        $path = $pdf->store('quizzes', 'public');

        // 🧠 Traitement à faire ici plus tard (génération IA ou autre...)

        return back()->with('success', '📄 تم تحميل الملف بنجاح! جاري تحليل المحتوى...');
    }
}
