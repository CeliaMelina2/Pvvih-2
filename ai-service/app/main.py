from fastapi import FastAPI, HTTPException
from pydantic import BaseModel
from typing import Optional, Dict
from dotenv import load_dotenv
import os

# Load .env from ai-service root
load_dotenv()

from app.services.chat_service import ChatService

class ChatRequest(BaseModel):
    message: str
    user_id: int
    conversation_id: Optional[str] = None
    context: Optional[Dict] = None

app = FastAPI(title="PVVIH Assistant API", version="0.1.0")

chat = ChatService()

@app.post("/chat")
async def chat_endpoint(req: ChatRequest):
    try:
        if not req.message or not req.message.strip():
            raise HTTPException(status_code=422, detail="message vide")
        answer = await chat.process_message(
            message=req.message,
            user_id=req.user_id,
            conversation_id=req.conversation_id,
            context=req.context,
        )
        return {"response": answer}
    except HTTPException:
        raise
    except Exception as e:
        print(f"Erreur dans chat_endpoint: {e}")
        # En cas d'erreur, retourner une réponse de fallback plutôt qu'une erreur 500
        error_msg = str(e).lower()
        if "quota" in error_msg or "insufficient_quota" in error_msg:
            fallback_response = chat._get_fallback_response(req.message)
            return {"response": fallback_response}
        else:
            return {"response": "Je rencontre des difficultés techniques temporaires. Pouvez-vous réessayer dans quelques instants ?"}

@app.get("/health")
async def health_check():
    return {"status": "ok", "service": "PVVIH Assistant API"}
