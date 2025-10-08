# Guide de configuration Qdrant Cloud pour le RAG

## Étapes de configuration

### 1. Créer un compte Qdrant Cloud
1. Allez sur https://cloud.qdrant.io/
2. Créez un compte (GitHub, Google ou email)
3. Activez votre compte par email

### 2. Créer un cluster
1. Cliquez sur "Create Cluster"
2. Choisissez :
   - **Nom** : pvvih-knowledge
   - **Région** : Europe (eu-central-1) pour la latence
   - **Plan** : Free tier (1GB, suffisant pour débuter)
3. Attendez le déploiement (quelques minutes)

### 3. Récupérer les credentials
1. Dans votre cluster, allez dans "Access"
2. Copiez :
   - **URL** : https://your-cluster-id.eu-central.aws.cloud.qdrant.io:6333
   - **API Key** : votre clé d'authentification

### 4. Configurer l'environnement
Éditez le fichier `ai-service/.env` :

```env
# Configuration Qdrant Cloud (RAG)
QDRANT_URL=https://your-cluster-id.eu-central.aws.cloud.qdrant.io:6333
QDRANT_API_KEY=votre-api-key-ici
QDRANT_COLLECTION=pvvih_knowledge
```

### 5. Tester la connexion
```bash
cd ai-service
python ingest_documents.py
```

## Structure des fichiers créés

```
ai-service/
├── knowledge/
│   ├── markdown/
│   │   ├── guide_vih_traitement.md
│   │   ├── vivre_quotidien_vih.md
│   │   └── prevention_vih_2025.md
│   └── pdf/
│       └── (vos fichiers PDF ici)
├── ingest_documents.py
└── .env
```

## Utilisation

1. **Première ingestion** : Les 3 fichiers markdown sont prêts
2. **Ajout de contenu** : Placez vos fichiers dans knowledge/markdown/ ou knowledge/pdf/
3. **Ré-indexation** : Relancez `python ingest_documents.py`

Le système RAG sera alors opérationnel et Nia pourra utiliser ces connaissances !
