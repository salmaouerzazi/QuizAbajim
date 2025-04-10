import os
import openai

client = openai.OpenAI(api_key=os.getenv("OPENAI_API_KEY"))
def load_prompt(prompt_path):
    with open(prompt_path, "r", encoding="utf-8") as f:
        return f.read()

def generate_mixed_quiz(text, num_questions=5, lang="français"):
    """
    Génère un quiz 'mixte' composé de n questions,
    en alternant : Relier -> V/F -> QCM -> V/F -> Relier -> ...
    Tout en respectant la langue 'lang' (arabe, français, anglais).
    """
    # Charger le prompt spécial "prompt_mixed.txt"
    base_dir = os.path.join(os.path.dirname(__file__), "..", "prompts")
    prompt_path = os.path.join(base_dir, "prompt_mixed.txt")
    prompt_template = load_prompt(prompt_path)

    # On injecte {n} + le texte
    prompt_text = prompt_template.format(text=text, n=num_questions)

    # Instruction stricte de langue
    instruction_langue = {
        "français": "⚠️ Rédige tout (y compris les consignes) en français. Ne mélange jamais les langues.",
        "anglais": "⚠️ Write EVERYTHING in English only. Do not mix languages.",
        "arabe":   "⚠️ اكتب كل شيء باللغة العربية فقط. لا تستخدم أي لغة أخرى مهما كان النص."
    }.get(lang.lower(), "")

    # On combine l'instruction de langue + le prompt
    user_prompt = instruction_langue + "\n\n" + prompt_text
    print("🔎 PROMPT ENVOYÉ :\n", user_prompt)  # debug

    # Message système dépendant de la langue
    if lang.lower() == "français":
        system_msg = (
            "Tu es un assistant éducatif. "
            "Réponds 100% en français, ne mélange jamais les langues."
        )
    elif lang.lower() == "anglais":
        system_msg = (
            "You are an educational assistant. Always respond in English, never mixing with other languages."
        )
    elif lang.lower() == "arabe":
        system_msg = (
            "أنت مساعد تربوي. لا تستخدم أي لغة سوى العربية إطلاقًا. "
            "إذا جاء نص بلغة أخرى، ترجمه للعربية فقط."
        )
    else:
        system_msg = "Always respond fully in the requested language."

    try:
        response = client.chat.completions.create(
            model="gpt-3.5-turbo",
            messages=[
                {"role": "system", "content": system_msg},
                {"role": "user", "content": user_prompt}
            ],
            temperature=0.3,
        )
        return response.choices[0].message.content
    except Exception as e:
        return f"❌ Erreur lors de la génération du quiz : {e}"