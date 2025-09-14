@extends('layouts.layout')

@section('content')
<style>
    :root {
        --primary-pink: #d1206f;
        --primary-purple: #811d73;
        --pink-lightest: #fdf2f7;
        --pink-light: #fbeaf1;
        --dark-blue: #010a43;
        --secondary-text: #6c757d;
        --success-green: #28a745;
        --info-blue: #17a2b8;
        --warning-yellow: #ffc107;
    }

    /* Styles généraux */
    .messages-header h1 {
        font-weight: 700;
        color: var(--dark-blue);
        letter-spacing: -1px;
    }
    .btn-primary-add {
        background-color: var(--primary-pink);
        color: white;
        border-radius: 0.75rem;
        font-weight: 600;
    }
    .btn-primary-add:hover {
        background-color: var(--primary-purple);
    }
    .card-modern {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        background-color: #fff;
    }
    .card-modern .section-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--primary-purple);
        text-transform: uppercase;
    }
    .card-modern .stat-value {
        font-size: 2.5rem;
        font-weight: bold;
        color: var(--dark-blue);
    }

    /* Styles pour la messagerie */
    .chat-container {
        display: flex;
        flex-direction: row;
        gap: 1.5rem;
    }
    .conversations-list {
        flex: 0 0 350px;
        min-height: 70vh;
        max-height: 80vh;
        overflow-y: auto;
        border-radius: 1rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
    }
    .chat-box {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 70vh;
        max-height: 80vh;
        border-radius: 1rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        background-color: var(--pink-lightest);
    }

    .message-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        cursor: pointer;
        border-bottom: 1px solid #f0e9fa;
        transition: background-color 0.2s;
    }
    .message-item:hover {
        background-color: var(--pink-lightest);
    }
    .message-item.unread {
        background-color: var(--pink-light);
        font-weight: 600;
    }

    .chat-header {
        display: flex;
        align-items: center;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--pink-light);
        background-color: #fff;
        border-radius: 1rem 1rem 0 0;
    }
    .chat-header .profile-name {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--dark-blue);
    }

    .chat-body {
        flex-grow: 1;
        padding: 1.5rem;
        overflow-y: auto;
        background-color: var(--main-bg);
    }

    .message-bubble {
        padding: 0.75rem 1.25rem;
        border-radius: 1.25rem;
        max-width: 80%;
        margin-bottom: 1rem;
    }
    .message-bubble.sent {
        background-color: var(--primary-pink);
        color: white;
        margin-left: auto;
        border-bottom-right-radius: 0.25rem;
    }
    .message-bubble.received {
        background-color: white;
        color: var(--dark-blue);
        margin-right: auto;
        border-bottom-left-radius: 0.25rem;
    }

    .chat-input {
        display: flex;
        padding: 1.5rem;
        background-color: #fff;
        border-radius: 0 0 1rem 1rem;
        border-top: 1px solid var(--pink-light);
    }
    .chat-input input {
        border-radius: 2rem;
        background-color: var(--pink-lightest);
        border: none;
        padding: 0.75rem 1.5rem;
    }
    .chat-input .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 2rem;
    }

    /* Réactivité pour les petits écrans */
    @media (max-width: 991px) {
        .conversations-list {
            position: fixed;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            z-index: 1000;
            background-color: white;
            transition: left 0.3s ease;
            box-shadow: none;
        }
        .conversations-list.show {
            left: 0;
        }
        .chat-box {
            width: 100%;
        }
    }
</style>

<div class="container-fluid py-4" style="background:var(--main-bg); min-height:90vh;">
    <div class="messages-header mb-4 d-flex justify-content-between align-items-center">
        <h1>Messagerie</h1>
        <a href="{{ route('aps.messages') }}" class="btn btn-primary-add px-4">
            <i class="bi bi-chat-dots me-2"></i>Nouveau message
        </a>
    </div>

    <!-- Statistiques messages -->
    <div class="row g-4 mb-4">
        <div class="col-6 col-md-3">
            <div class="card-modern text-center p-4">
                <div class="section-title mb-1">Total</div>
                <div class="stat-value">152</div>
                <div class="text-muted">Messages</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card-modern text-center p-4">
                <div class="section-title mb-1">Non lus</div>
                <div class="stat-value">7</div>
                <div class="text-muted">Non lus</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card-modern text-center p-4">
                <div class="section-title mb-1">Envoyés</div>
                <div class="stat-value">85</div>
                <div class="text-muted">Envoyés</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card-modern text-center p-4">
                <div class="section-title mb-1">Réponses</div>
                <div class="stat-value">60</div>
                <div class="text-muted">Réponses</div>
            </div>
        </div>
    </div>

    <!-- Interface de chat -->
    <div class="chat-container">
        <!-- Liste des messages -->
        <div class="conversations-list bg-white">
            <div class="card-header bg-white border-0">
                <div class="section-title">Conversations</div>
            </div>
            <div class="card-body p-0">
                @php
                    $fakeMessages = [
                        ['sender'=>'Jean Dupont','subject'=>'Rendez-vous','preview'=>'Bonjour docteur, je souhaite confirmer mon rendez-vous du 15 septembre.','time'=>'2h ago','is_read'=>false],
                        ['sender'=>'Marie Durand','subject'=>'Résultats','preview'=>'Merci pour les résultats, tout est clair.','time'=>'4h ago','is_read'=>true],
                        ['sender'=>'Paul Martin','subject'=>'Question traitement','preview'=>'Docteur, j’ai une question sur la prise de mon médicament.','time'=>'6h ago','is_read'=>false],
                        ['sender'=>'Sophie Legrand','subject'=>'Consultation','preview'=>'Je souhaite reporter ma consultation prévue le 16 septembre.','time'=>'1d ago','is_read'=>true],
                        ['sender'=>'Marc Olivier','subject'=>'Facture en cours','preview'=>'Bonjour, je vous contacte concernant la facture du mois.','time'=>'2d ago','is_read'=>false],
                        ['sender'=>'Julien Goupil','subject'=>'Problème de santé','preview'=>'Bonjour, j\'aimerais parler d\'un problème de santé récurrent.','time'=>'3d ago','is_read'=>true],
                    ];
                @endphp
                @foreach($fakeMessages as $msg)
                <div class="message-item @if(!$msg['is_read']) unread @endif">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($msg['sender']) }}&background=d1206f&color=fff&size=48" class="rounded-circle me-3" style="width:48px;" alt="Avatar">
                    <div class="w-100">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="fw-bold">{{ $msg['sender'] }}</div>
                            <small class="text-muted">{{ $msg['time'] }}</small>
                        </div>
                        <div class="text-muted text-truncate" style="font-size:0.9rem;">{{ $msg['preview'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Espace de chat -->
        <div class="chat-box">
            <div class="chat-header">
                <img src="https://ui-avatars.com/api/?name=Jean+Dupont&background=d1206f&color=fff&size=48" class="rounded-circle me-3" style="width:48px;" alt="Avatar">
                <div class="profile-name">Jean Dupont</div>
            </div>
            <div class="chat-body d-flex flex-column">
                <!-- Messages (à remplacer par une boucle de données) -->
                <div class="message-bubble received">
                    Bonjour docteur, je souhaite confirmer mon rendez-vous du 15 septembre.
                </div>
                <div class="message-bubble sent">
                    Bonjour Jean, c'est bien noté. À très bientôt !
                </div>
                <div class="message-bubble received">
                    Parfait, merci beaucoup.
                </div>
            </div>
            <div class="chat-input">
                <input type="text" class="form-control me-2" placeholder="Écrire un message...">
                <button class="btn btn-primary-add"><i class="bi bi-send-fill"></i></button>
            </div>
        </div>
    </div>

    <div class="text-center text-muted mt-4" style="font-size:0.95rem;">
        &copy; 2025 Pvvih - Messagerie Médecin. Design fictif.
    </div>
</div>
@endsection
