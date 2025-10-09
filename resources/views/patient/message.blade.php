@extends('layouts.layout')

@section('content')
<style>
    /* Styles personnalisés pour la messagerie */
    .message-container {
        display: flex;
        height: calc(100vh - 150px); /* Ajuster la hauteur pour qu'elle ne déborde pas */
        border-radius: 1rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        background-color: white;
    }
    .contact-list {
        width: 320px; /* Largeur réduite */
        border-right: 1px solid #e9ecef;
        background-color: #f8f9fa;
        overflow-y: auto;
    }
    .conversation-window {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .contact-item {
        padding: 1rem;
        border-bottom: 1px solid #e9ecef;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    .contact-item:hover, .contact-item.active {
        background-color: #e9ecef;
    }
    .profile-pic {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }
    .message-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e9ecef;
        background-color: white;
    }
    .message-body {
        flex-grow: 1;
        padding: 1.5rem;
        overflow-y: auto;
        background-color: #f8f9fa;
    }
    .message-input {
        padding: 1.5rem;
        border-top: 1px solid #e9ecef;
        background-color: white;
    }
    .sent-message, .received-message {
        margin-bottom: 1rem;
        padding: 0.75rem 1.25rem;
        border-radius: 1.25rem;
        max-width: 80%;
    }
    .sent-message {
        background-color: #D01168;
        color: white;
        margin-left: auto;
        text-align: right;
    }
    .received-message {
        background-color: #e9ecef;
        color: #212529;
        margin-right: auto;
        text-align: left;
    }
    /* Styles pour le mode mobile */
    @media (max-width: 768px) {
        .message-container {
            flex-direction: column;
            height: auto;
        }
        .contact-list {
            width: 100%;
            height: 250px;
        }
        .conversation-window {
            height: 600px;
        }
    }
</style>

<div class="container-fluid py-4">
    <h1 class="fw-bold mb-4">Messages</h1>

    <div class="message-container">
        <div class="contact-list d-none d-md-block">
            <div class="p-3 fw-bold border-bottom">Discussions récentes</div>
            
            <div class="contact-item active" data-name="M. Jean-Marc Dupont" data-image="/images/aps.png">
                <div class="d-flex align-items-center">
                    <img src="/images/aps.png" alt="Profil APS" class="profile-pic me-3">
                    <div>
                        <div class="fw-bold">M. Jean-Marc Dupont</div>
                        <small class="text-muted">Vous: OK, merci beaucoup !</small>
                    </div>
                </div>
            </div>

            <div class="contact-item" data-name="Dr. Ndi" data-image="/images/doctor.png">
                <div class="d-flex align-items-center">
                    <img src="/images/doctor.png" alt="Profil Médecin" class="profile-pic me-3">
                    <div>
                        <div class="fw-bold">Dr. Ndi</div>
                        <small class="text-muted">Je suis disponible demain...</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="conversation-window">
            <div class="message-header d-flex align-items-center">
                <img id="header-pic" src="/images/aps.png" alt="Profil APS" class="profile-pic me-3">
                <div>
                    <h5 id="header-name" class="fw-bold mb-0">M. Jean-Marc Dupont</h5>
                    <small class="text-success">En ligne</small>
                </div>
            </div>

            <div class="message-body" id="chat-body">
                <div class="received-message">
                    Bonjour, j'ai bien reçu votre demande de rendez-vous. Nous pouvons le fixer pour le 19 septembre. Est-ce que cela vous convient ?
                </div>
                <div class="sent-message">
                    Bonjour M. Essomba, oui, le 19 septembre est parfait pour moi. Merci beaucoup !
                </div>
                <div class="received-message">
                    Parfait, je vous envoie la confirmation. Prenez soin de vous.
                </div>
            </div>

            <div class="message-input">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Écrire un message...">
                    <button class="btn btn-primary" type="button" id="button-addon2">
                        <i class="bi bi-send-fill"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const contactItems = document.querySelectorAll('.contact-item');
        const headerName = document.getElementById('header-name');
        const headerPic = document.getElementById('header-pic');
        const chatBody = document.getElementById('chat-body');

        // Contenus des conversations (à remplacer par de vraies données)
        const conversations = {
            "M. Jean-Marc Dupont": `
                <div class="received-message">
                    Bonjour, j'ai bien reçu votre demande de rendez-vous. Nous pouvons le fixer pour le 19 septembre. Est-ce que cela vous convient ?
                </div>
                <div class="sent-message">
                    Bonjour M. Dupont, oui, le 19 septembre est parfait pour moi. Merci beaucoup !
                </div>
                <div class="received-message">
                    Parfait, je vous envoie la confirmation. Prenez soin de vous.
                </div>
            `,
            "Dr. Ndi": `
                <div class="received-message">
                    Bonjour, j'ai analysé vos derniers résultats. Ils sont excellents. Nous pouvons nous voir pour en discuter.
                </div>
                <div class="sent-message">
                    C'est une super nouvelle, merci Dr. Ndi ! Je suis disponible demain.
                </div>
            `
        };

        contactItems.forEach(item => {
            item.addEventListener('click', function() {
                // Supprimer la classe 'active' de tous les contacts
                contactItems.forEach(i => i.classList.remove('active'));

                // Ajouter la classe 'active' au contact cliqué
                this.classList.add('active');

                // Récupérer les données du contact cliqué
                const newName = this.getAttribute('data-name');
                const newImage = this.getAttribute('data-image');
                
                // Mettre à jour l'en-tête de la conversation
                headerName.textContent = newName;
                headerPic.src = newImage;

                // Mettre à jour le contenu de la conversation
                chatBody.innerHTML = conversations[newName] || "Aucune discussion récente.";
            });
        });
    });
</script>
@endsection