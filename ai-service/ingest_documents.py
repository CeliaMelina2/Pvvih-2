# Script d'ingestion de documents pour Qdrant
# Utilise le RAGService pour indexer du contenu dans la base vectorielle

import os
import sys
import asyncio
from pathlib import Path
from typing import List, Dict, Any
from dotenv import load_dotenv

# Charger les variables d'environnement
load_dotenv()

# Ajouter le dossier parent au PYTHONPATH
sys.path.append(str(Path(__file__).parent.parent))

from app.services.rag_service import RAGService

def load_markdown_files(directory: str) -> List[Dict[str, Any]]:
    """Charge tous les fichiers .md d'un répertoire"""
    docs = []
    md_dir = Path(directory)
    
    if not md_dir.exists():
        print(f"Répertoire {directory} non trouvé")
        return docs
    
    for md_file in md_dir.glob("*.md"):
        try:
            with open(md_file, 'r', encoding='utf-8') as f:
                content = f.read().strip()
                if content:
                    docs.append({
                        'id': str(md_file.stem),
                        'text': content,
                        'metadata': {
                            'source': str(md_file.name),
                            'type': 'markdown',
                            'file_path': str(md_file)
                        }
                    })
                    print(f"✓ Chargé: {md_file.name}")
        except Exception as e:
            print(f"✗ Erreur lors du chargement de {md_file}: {e}")
    
    return docs

def load_pdf_files(directory: str) -> List[Dict[str, Any]]:
    """Charge tous les fichiers .pdf d'un répertoire (nécessite pypdf)"""
    docs = []
    pdf_dir = Path(directory)
    
    if not pdf_dir.exists():
        print(f"Répertoire {directory} non trouvé")
        return docs
    
    try:
        from pypdf import PdfReader
    except ImportError:
        print("pypdf non installé. Exécutez: pip install pypdf")
        return docs
    
    for pdf_file in pdf_dir.glob("*.pdf"):
        try:
            reader = PdfReader(str(pdf_file))
            text_parts = []
            
            for page in reader.pages:
                text = page.extract_text()
                if text.strip():
                    text_parts.append(text.strip())
            
            if text_parts:
                full_text = "\n\n".join(text_parts)
                docs.append({
                    'id': str(pdf_file.stem),
                    'text': full_text,
                    'metadata': {
                        'source': str(pdf_file.name),
                        'type': 'pdf',
                        'file_path': str(pdf_file),
                        'pages': len(reader.pages)
                    }
                })
                print(f"✓ Chargé: {pdf_file.name} ({len(reader.pages)} pages)")
        except Exception as e:
            print(f"✗ Erreur lors du chargement de {pdf_file}: {e}")
    
    return docs

def main():
    """Script principal d'ingestion"""
    print("🚀 Démarrage de l'ingestion Qdrant...")
    
    # Initialiser le service RAG
    rag_service = RAGService()
    
    if not rag_service.enabled:
        print("❌ RAG Service désactivé. Vérifiez vos variables d'environnement:")
        print("   - QDRANT_URL")
        print("   - QDRANT_API_KEY")
        print("   - QDRANT_COLLECTION (optionnel)")
        return
    
    print(f"✓ Connexion à Qdrant: {rag_service.qdrant_url}")
    print(f"✓ Collection: {rag_service.collection}")
    
    # Créer les répertoires s'ils n'existent pas
    knowledge_dir = Path(__file__).parent / "knowledge"
    knowledge_dir.mkdir(exist_ok=True)
    
    markdown_dir = knowledge_dir / "markdown"
    pdf_dir = knowledge_dir / "pdf"
    markdown_dir.mkdir(exist_ok=True)
    pdf_dir.mkdir(exist_ok=True)
    
    print(f"\nRépertoires de contenu:")
    print(f"  - Markdown: {markdown_dir}")
    print(f"  - PDF: {pdf_dir}")
    
    # Charger les documents
    all_docs = []
    
    # Charger les fichiers Markdown
    print("\n📄 Chargement des fichiers Markdown...")
    md_docs = load_markdown_files(str(markdown_dir))
    all_docs.extend(md_docs)
    
    # Charger les fichiers PDF
    print("\n📑 Chargement des fichiers PDF...")
    pdf_docs = load_pdf_files(str(pdf_dir))
    all_docs.extend(pdf_docs)
    
    if not all_docs:
        print("\n⚠️  Aucun document trouvé à indexer.")
        print("\nPour ajouter du contenu:")
        print(f"  1. Placez vos fichiers .md dans: {markdown_dir}")
        print(f"  2. Placez vos fichiers .pdf dans: {pdf_dir}")
        print("  3. Relancez ce script")
        return
    
    print(f"\n📊 Total: {len(all_docs)} documents à indexer")
    
    # Indexer dans Qdrant
    try:
        print("\n🔄 Indexation en cours...")
        indexed_count = rag_service.upsert_documents(all_docs)
        print(f"✅ {indexed_count} documents indexés avec succès!")
        
        # Test de recherche
        print("\n🔍 Test de recherche...")
        test_results = rag_service.query("VIH traitement", top_k=2)
        if test_results:
            print(f"✓ {len(test_results)} résultats trouvés")
            for i, result in enumerate(test_results[:2], 1):
                source = result.get('metadata', {}).get('source', 'Inconnue')
                score = result.get('score', 0)
                print(f"  {i}. {source} (score: {score:.3f})")
        else:
            print("⚠️  Aucun résultat de test trouvé")
            
    except Exception as e:
        print(f"❌ Erreur lors de l'indexation: {e}")
        return
    
    print("\n🎉 Ingestion terminée avec succès!")
    print("\nLe système RAG est maintenant opérationnel.")

if __name__ == "__main__":
    main()
