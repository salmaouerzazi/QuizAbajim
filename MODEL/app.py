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
        quiz_parsed = parse_quiz_text(quiz_raw_text)
        return jsonify({"language": lang_to_use, "quiz": quiz_parsed})

        

    except Exception as e:
        traceback.print_exc()
        return jsonify({"error": str(e)}), 500

import re

def parse_quiz_text(raw_text):
    questions = []

    # Séparer les blocs de questions avec "سؤال"
    blocks = re.split(r'\n(?=سؤال \d+)', raw_text.strip())

    for block in blocks:
        if '(ربط)' in block:
            question = {
                "type": "matching",
                "question_text": "",
                "column_a": [],
                "column_b": [],
                "matches": {}
            }

            # Texte avant "العمود أ"
            title_match = re.search(r'سؤال \d+ \(ربط\) ?:?\n?(.*?)العمود أ', block, re.DOTALL)
            if title_match:
                question["question_text"] = title_match.group(1).strip()

            # Colonne A
            column_a_match = re.findall(r'العمود أ\s*:\s*((?:\d\)\s?.+\n?)+)', block)
            if column_a_match:
                question["column_a"] = [line.strip()[3:] for line in column_a_match[0].strip().split('\n') if line.strip()]

            # Colonne B
            column_b_match = re.findall(r'العمود ب\s*:\s*((?:[أ-ي]\)\s?.+\n?)+)', block)
            if column_b_match:
                question["column_b"] = [line.strip()[3:] for line in column_b_match[0].strip().split('\n') if line.strip()]

            # Correspondances
            matches = re.findall(r'(\d+)\s*→\s*([أ-ي])', block)
            question["matches"] = {q: a for q, a in matches}

            questions.append(question)

        elif '(صح أم خطأ)' in block:
            statement_match = re.search(r'\n(.*?)\nالإجابة الصحيحة\s*[:：]\s*(صحيح|خطأ)', block, re.DOTALL)
            if statement_match:
                question_text = statement_match.group(1).strip()
                correct_answer = statement_match.group(2).strip() == 'صحيح'

                questions.append({
                    "type": "true_false",
                    "question_text": question_text,
                    "correct_answer": correct_answer
                })

        elif '(اختيار من متعدد)' in block:
            question_match = re.search(r'\n(.*?)\n1\.', block, re.DOTALL)
            answers_match = re.findall(r'([أ-ي])\)\s*(.+)', block)
            correct_match = re.search(r'الإجابة الصحيحة\s*[:：]\s*([أ-ي])', block)

            if question_match:
                question_text = question_match.group(1).strip()
                choices = {letter: text.strip() for letter, text in answers_match}
                correct = correct_match.group(1).strip() if correct_match else None

                questions.append({
                    "type": "multiple",
                    "question_text": question_text,
                    "choices": choices,
                    "correct_answer": correct
                })

    return questions


if __name__ == "__main__":
    app.run(host="0.0.0.0", port=8080, debug=True)
