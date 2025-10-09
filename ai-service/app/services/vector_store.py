import os
from typing import List, Dict

# NOTE: Implémentation temporaire sans base vectorielle pour compatibilité Windows.
# Quand vous souhaitez réactiver Chroma, on rétablira l'implémentation et les dépendances.

KB_DIR = os.path.join(os.path.dirname(__file__), "..", "data", "knowledge_base")

class VectorStore:
    def __init__(self):
        # Stub: aucune initialisation de base vectorielle
        pass

    def similarity_search(self, query: str, k: int = 4) -> List[Dict]:
        # Stub: renvoie aucune source pertinente
        return []

    @staticmethod
    def format_context(results: List[Dict], max_chars: int = 2000) -> str:
        # Même signature que la vraie version pour compatibilité
        out: List[str] = []
        total = 0
        for r in results:
            t = str(r.get("text", "")).strip()
            if total + len(t) > max_chars:
                break
            meta = r.get('metadata', {}) or {}
            source = meta.get('source', 'inconnu')
            out.append(f"[Extrait] Source: {source}\n{t}")
            total += len(t)
        return "\n\n".join(out)
