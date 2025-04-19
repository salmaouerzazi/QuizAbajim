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
        # ✅ Priorité au champ text si présent
        if 'text' in request.form:
            text = request.form['text']
        elif 'pdf' in request.files:
            pdf_file = request.files['pdf']
            if not pdf_file:
                return jsonify({"error": "Aucun fichier PDF fourni"}), 400

            with tempfile.NamedTemporaryFile(delete=False, suffix=".pdf") as temp:
                pdf_file.save(temp.name)
                text = extract_text_from_pdf(temp.name)
        else:
            return jsonify({"error": "Aucun champ texte ou PDF trouvé"}), 400

        if not text.strip():
            return jsonify({"error": "Texte vide"}), 400

        num_questions = int(request.form.get('num_questions', 5))
        forced_lang = request.form.get('lang', 'auto').lower()
        lang_to_use = detect_language(text) if forced_lang == 'auto' else forced_lang

        quiz_raw_text = generate_mixed_quiz(text, num_questions, lang=lang_to_use)

        return jsonify({
            "language": lang_to_use,
            "quiz": quiz_raw_text,
            "text": text
        })

    except Exception as e:
        traceback.print_exc()
        return jsonify({"error": str(e)}), 500



if __name__ == "__main__":
    app.run(host="0.0.0.0", port=8080, debug=True)
