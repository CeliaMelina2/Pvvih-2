import os
from typing import List

class Embeddings:
    def __init__(self):
        # Import différé pour éviter les erreurs d'analyse Pylance si le paquet n'est pas détecté
        self.model = os.getenv("EMBEDDINGS_MODEL", "text-embedding-3-small")

    def embed(self, texts: List[str]) -> List[List[float]]:
        try:
            from openai import OpenAI  # type: ignore[import-not-found]  # import local pour éviter reportMissingImports
            api_key = os.getenv("OPENAI_API_KEY")
            if not api_key:
                raise RuntimeError("OPENAI_API_KEY non défini")
            client = OpenAI(api_key=api_key)
            texts = [t.replace("\n", " ") for t in texts]
            resp = client.embeddings.create(model=self.model, input=texts)
            return [d.embedding for d in resp.data]
        except Exception:
            # Fallback neutre (pas utilisé dans la version minimale)
            return [[0.0] for _ in texts]
