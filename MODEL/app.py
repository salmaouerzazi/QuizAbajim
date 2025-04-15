from flask import Flask, request, jsonify
import os
import tempfile
from utils.pdf_utils import extract_text_from_pdf, detect_language
from utils.gpt_utils import generate_mixed_quiz
import traceback

app = Flask(__name__)
@app.route("/", methods=["GET"])
def home():
    return "🚀 Bienvenue sur l'API de génération de quiz ! Utilisez POST /generate_quiz pour envoyer un fichier PDF."
@app.route('/generate_quiz', methods=['POST'])
def generate_quiz():
    try:
        pdf_file = request.files.get('pdf')
        if not pdf_file:
            return jsonify({"error": "Aucun fichier PDF fourni"}), 400

        # Lire les paramètres optionnels
        num_questions = int(request.form.get('num_questions', 5))
        forced_lang = request.form.get('lang', 'auto').lower()

        # Sauvegarder temporairement le fichier
        with tempfile.NamedTemporaryFile(delete=False, suffix=".pdf") as temp:
            pdf_file.save(temp.name)
            text = extract_text_from_pdf(temp.name)

        if not text:
            return jsonify({"error": "Aucun texte extrait du fichier PDF."}), 400

        # Langue
        lang_to_use = detect_language(text) if forced_lang == 'auto' else forced_lang

        # Générer le quiz
        quiz_raw_text = generate_mixed_quiz(text, num_questions, lang=lang_to_use)
        return jsonify({"language": lang_to_use, "quiz": quiz_raw_text})

        

    except Exception as e:
        traceback.print_exc()
        return jsonify({"error": str(e)}), 500



if __name__ == "__main__":
    app.run(host="0.0.0.0", port=8080, debug=True)
