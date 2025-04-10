import fitz 
from langdetect import detect


def extract_text_from_pdf(pdf_path):
    """Extrait le texte depuis un PDF."""
    try:
        doc = fitz.open(pdf_path)
        text = "\n".join(page.get_text("text") for page in doc)
        return text.strip()
    except Exception as e:
        print(f"Erreur lors de l'ouverture du PDF : {e}")
        return ""

def detect_language(text):
    """Détecte la langue du texte (ar, fr, en) et la remappe en 'arabe', 'français', 'anglais'."""
    try:
        code = detect(text)
        return {
            "fr": "français",
            "en": "anglais",
            "ar": "arabe"
        }.get(code, code)
    except:
        return "inconnue"
