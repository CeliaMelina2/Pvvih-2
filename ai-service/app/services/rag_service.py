import os
from typing import List, Dict, Any, Optional

# Import résilient pour qdrant-client selon les versions
try:  # qdrant-client>=1.5 expose aussi qdrant_client.models
    from qdrant_client import QdrantClient  # type: ignore[import-not-found]
    try:
        from qdrant_client import models as qmodels  # type: ignore[attr-defined]
    except Exception:  # fallback anciennes versions
        from qdrant_client.http import models as qmodels  # type: ignore[import-not-found]
except Exception:  # dernier recours
    from qdrant_client import QdrantClient  # type: ignore
    from qdrant_client.http import models as qmodels  # type: ignore

from openai import OpenAI  # type: ignore[import-not-found]

DEFAULT_EMBEDDING_MODEL = os.getenv("EMBEDDING_MODEL", "text-embedding-3-small")
EMBEDDING_DIM = 1536 if "small" in DEFAULT_EMBEDDING_MODEL else 3072

class RAGService:
    def __init__(self) -> None:
        self.qdrant_url = os.getenv("QDRANT_URL")
        self.qdrant_api_key = os.getenv("QDRANT_API_KEY")
        self.collection = os.getenv("QDRANT_COLLECTION", "pvvih_knowledge")
        self.enabled = bool(self.qdrant_url and self.qdrant_api_key)
        self.client: Optional[QdrantClient] = None
        self.openai: Optional[OpenAI] = None

        if self.enabled:
            self.client = QdrantClient(url=self.qdrant_url, api_key=self.qdrant_api_key, timeout=30)
            self.openai = OpenAI(api_key=os.getenv("OPENAI_API_KEY"))
            self._ensure_collection()

    def _ensure_collection(self) -> None:
        assert self.client is not None
        exists = False
        try:
            info = self.client.get_collection(self.collection)
            exists = info is not None
        except Exception:
            exists = False
        if not exists:
            self.client.recreate_collection(
                collection_name=self.collection,
                vectors_config=qmodels.VectorParams(size=EMBEDDING_DIM, distance=qmodels.Distance.COSINE),
            )

    def _embed(self, texts: List[str]) -> List[List[float]]:
        assert self.openai is not None
        resp = self.openai.embeddings.create(model=DEFAULT_EMBEDDING_MODEL, input=texts)
        return [d.embedding for d in resp.data]

    def upsert_documents(self, docs: List[Dict[str, Any]]) -> int:
        """docs: [{id?: str, text: str, metadata?: dict}]"""
        if not self.enabled:
            return 0
        assert self.client is not None
        payloads = []
        texts = []
        ids: List[str] = []
        for i, d in enumerate(docs):
            text = d.get("text", "").strip()
            if not text:
                continue
            ids.append(str(d.get("id", i)))
            texts.append(text)
            payloads.append({"text": text, **(d.get("metadata") or {})})
        if not texts:
            return 0
        vectors = self._embed(texts)
        points = [
            qmodels.PointStruct(id=ids[i], vector=vectors[i], payload=payloads[i])
            for i in range(len(texts))
        ]
        self.client.upsert(collection_name=self.collection, points=points)
        return len(points)

    def query(self, query_text: str, top_k: int = 4) -> List[Dict[str, Any]]:
        if not self.enabled or not query_text.strip():
            return []
        assert self.client is not None
        vector = self._embed([query_text])[0]
        result = self.client.search(
            collection_name=self.collection,
            query_vector=vector,
            limit=top_k,
            with_payload=True,
        )
        out: List[Dict[str, Any]] = []
        for r in result:
            payload = r.payload or {}
            out.append({
                "text": payload.get("text", ""),
                "score": float(r.score or 0.0),
                "metadata": {k: v for k, v in payload.items() if k != "text"}
            })
        return out
