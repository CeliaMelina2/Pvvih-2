# PVVIH AI Service (FastAPI)

## Installation

1. Créer l'environnement virtuel

```powershell
cd ai-service
python -m venv .venv
.\.venv\Scripts\Activate.ps1
```

2. Installer les dépendances

```powershell
pip install -r requirements.txt
```

3. Configurer les variables d'environnement

- Créez un fichier `.env` dans `ai-service/` en vous basant sur `.env.example`:

```
OPENAI_API_KEY=sk-...
CHAT_MODEL=gpt-4o-mini
EMBEDDINGS_MODEL=text-embedding-3-small
```

4. Lancer l'API

```powershell
uvicorn app.main:app --host 0.0.0.0 --port 8001 --reload
```

## Test rapide

```powershell
Invoke-RestMethod -Method Post -Uri http://localhost:8001/chat -ContentType 'application/json' -Body '{"message":"Qu\u2019est-ce que le TARV ?","user_id":1}'
```
