import os
from typing import Optional, Dict
from openai import OpenAI  # type: ignore[import-not-found]
from .rag_service import RAGService

PERSONA = (
    "Tu es Nia, une assistante virtuelle chaleureuse, empathique et fiable, spécialisée dans l'accompagnement des personnes vivant avec le VIH. "
    "Tu t'exprimes en français, dans un ton humain, respectueux et rassurant. "
    "Tu as été créée par Celia Mélina en octobre 2025 pour la plateforme PV-VIH, afin d'offrir une information claire, un soutien bienveillant et une orientation adaptée. "
    "Ta mission: aider à comprendre le VIH et ses traitements, encourager l'observance, soutenir le bien-être global et orienter vers des professionnels quand c'est nécessaire. "
    "Valeurs: empathie, absence de jugement, confidentialité, exactitude. Style: clair, concis, structuré (titres ou puces si utile), concret. "
    "Capacités: vulgariser, contextualiser avec les données fournies, synthétiser les sources fiables, proposer des étapes pratiques (check-lists, conseils). "
    "Limites: tu ne poses pas de diagnostic, ne remplaces pas un avis médical et ne fournis pas d'urgence; en cas de symptôme grave ou urgence, conseille de contacter un professionnel ou les numéros d'urgence. "
    "Quand tu es incertaine ou que la question est hors de ton champ, explique calmement tes limites et propose des alternatives. "
)

class ChatService:
    def __init__(self):
        api_key = os.getenv("OPENAI_API_KEY")
        if not api_key:
            raise RuntimeError("OPENAI_API_KEY non défini")
        self.client = OpenAI(api_key=api_key)
        self.model = os.getenv("CHAT_MODEL", "gpt-4o-mini")
        self.rag = RAGService()

    async def process_message(self, message: Optional[str], user_id: int, conversation_id: Optional[str] = None, context: Optional[Dict] = None) -> str:
        system_prompt = PERSONA

        # Contexte patient du contrôleur
        if context:
            system_prompt += "\n\nContexte utilisateur (du système):\n" + str(context)

        # RAG: recherche dans Qdrant si activé
        citations = []
        rag_chunks = []
        try:
            if self.rag and self.rag.enabled and message:
                results = self.rag.query(message, top_k=4)
                for r in results:
                    txt = (r.get("text") or "").strip()
                    if txt:
                        rag_chunks.append(txt)
                        src = r.get("metadata", {}).get("source")
                        if src:
                            citations.append(src)
        except Exception:
            # pas bloquant si RAG HS
            pass

        if rag_chunks:
            system_prompt += "\n\nBase de connaissances (extraits):\n" + "\n---\n".join(rag_chunks[:4])

        user_prompt = (message or "").strip()
        if not user_prompt:
            return "Pouvez-vous préciser votre question ?"

        try:
            resp = self.client.chat.completions.create(
                model=self.model,
                messages=[
                    {"role": "system", "content": system_prompt},
                    {"role": "user", "content": user_prompt},
                ],
                temperature=0.5,
                max_tokens=500,
            )
            content = None
            try:
                content = resp.choices[0].message.content
            except Exception:
                content = None
            suffix = ""
            if citations:
                suffix = "\n\nSources: " + ", ".join(sorted(set(citations)))
            return ((content or "Désolé, je n'ai pas pu générer de réponse.").strip() + suffix).strip()
        except Exception as e:
            # Fallback déjà géré dans version précédente
            error_str = str(e).lower()
            if "quota" in error_str or "insufficient_quota" in error_str:
                return self._get_fallback_response(user_prompt)
            return "Je rencontre temporairement des difficultés techniques."

    def _get_fallback_response(self, user_prompt: str) -> str:
        """Réponses préprogrammées en cas de problème avec l'API OpenAI"""
        prompt_lower = user_prompt.lower()
        
        if any(word in prompt_lower for word in ["bonjour", "salut", "hello", "bonsoir"]):
            return """**Bonjour ! 😊**

Je suis **Nia**, votre assistante virtuelle spécialisée dans l'accompagnement des personnes vivant avec le VIH.

**Mes domaines d'expertise :**
• Questions sur le VIH et les traitements
• Conseils sur le bien-être et la prévention  
• Soutien psychologique et informations pratiques
• Orientation vers des professionnels si nécessaire

Je suis née d'une initiative de **Celia Mélina** (octobre 2025) pour soutenir et mieux informer. 

Comment puis-je vous aider aujourd'hui ? 💖"""

        elif any(word in prompt_lower for word in ["merci", "remercie"]):
            return "C'est un plaisir de vous aider ! 💖 C'est exactement pourquoi j'ai été créée par Celia Mélina. N'hésitez pas si vous avez d'autres questions !"

        elif any(word in prompt_lower for word in ["qui es-tu", "qui êtes-vous", "présente-toi"]):
            return """**Qui suis-je ? 🤖**

Je suis **Nia**, une assistante virtuelle créée par **Celia Mélina** en octobre 2025 pour la plateforme PV-VIH ! 😊

**Ma mission :**
• Fournir des informations fiables sur le VIH et les traitements
• Offrir un soutien empathique et sans jugement  
• Donner des conseils pratiques pour le bien-être
• Orienter vers des professionnels quand nécessaire

**Mes valeurs :** Empathie, confidentialité, exactitude et bienveillance.

Je suis là pour vous écouter et vous aider du mieux que je peux ! 💖"""

        elif any(word in prompt_lower for word in ["vih", "sida", "traitement", "arv"]):
            return """**VIH & Traitements 🏥**

Je suis spécialisée dans l'accompagnement VIH ! 💖

**⚠️ Important :** Pour des informations médicales précises, consultez toujours votre médecin traitant ou un professionnel de santé spécialisé.

**Points clés à retenir :**
• **Traitement efficace** : Le VIH se traite très bien aujourd'hui avec les trithérapies
• **Suivi régulier** : Un suivi médical régulier est essentiel
• **I=I** : Charge virale indétectable = non transmissible  
• **Soutien global** : L'accompagnement psychologique est important

**Avez-vous une question spécifique ?** N'hésitez pas à consulter un professionnel pour des conseils personnalisés."""

        else:
            return """**Difficultés techniques temporaires 🔧**

Je rencontre temporairement des difficultés techniques, mais je reste à votre écoute ! 😊

**Ressources utiles en attendant :**
• **Urgence médicale** : Contactez votre médecin ou le **15**
• **Sida Info Service** : **0 800 840 800** (gratuit, anonyme, 24h/24)
• **AIDES** : Association de lutte contre le VIH/sida

**Pouvez-vous reformuler votre question ?** Je ferai de mon mieux pour vous aider ! 💖"""
