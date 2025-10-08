<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Assistant VIH - Nia</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    :root {
      --primary-pink: #D01168;
      --secondary-light: #f8f9fa;
      --dark-gray: #212529;
      --border-color: #e9ecef;
      --chat-bg: #fafbfc;
      --user-msg: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      --bot-msg: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
      /* hauteur du header calculée dynamiquement en JS */
      --header-h: 72px;
    }

    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      overflow-x: hidden;
    }

    .chat-container {
      max-width: 1200px;
      height: 95vh;
      backdrop-filter: blur(20px);
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.2);
      overflow: hidden;
      display: flex;
      flex-direction: column;
      position: relative;
    }

    .chat-header {
      background: var(--primary-pink);
      color: white;
      padding: 1.5rem;
      border-radius: 20px 20px 0 0;
      position: sticky;
      top: 0;
      z-index: 1050; /* au-dessus de la sidebar */
      overflow: hidden;
    }

    .chat-header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, transparent 100%);
    }

    .chat-header h4 {
      margin: 0;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .status-indicator {
      width: 12px;
      height: 12px;
      background: #00ff88;
      border-radius: 50%;
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0% { opacity: 1; }
      50% { opacity: 0.5; }
      100% { opacity: 1; }
    }

    .sidebar {
      background: var(--secondary-light);
      border-right: 1px solid var(--border-color);
      height: 100%;
      overflow: hidden;
      display: flex;
      flex-direction: column;
    }

    .sidebar-header {
      padding: 1.5rem;
      border-bottom: 1px solid var(--border-color);
      background: white;
    }

    .conv-list {
      flex: 1;
      overflow-y: auto;
      padding: 1rem;
      min-height: 0;
    }

    .conv-item {
      background: white;
      border: 1px solid var(--border-color);
      border-radius: 12px;
      padding: 1rem;
      margin-bottom: 0.75rem;
      cursor: pointer;
      transition: all 0.3s ease;
      position: relative;
    }

    .conv-item:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
      border-color: var(--primary-pink);
    }

    .conv-item.active {
      background: var(--primary-pink);
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(208, 17, 104, 0.3);
    }

    .conv-actions {
      opacity: 0;
      transition: opacity 0.2s ease;
    }

    .conv-item:hover .conv-actions,
    .conv-item.active .conv-actions {
      opacity: 1;
    }

    .messages-area {
      background: var(--chat-bg);
      flex: 1;
      overflow-y: auto;
      padding: 1.5rem;
      scroll-behavior: smooth;
      min-height: 0;
      /* espace pour éviter que les derniers messages passent sous l'input */
      padding-bottom: 120px;
    }

    .message-wrapper {
      margin-bottom: 1.5rem;
      animation: fadeInUp 0.4s ease;
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .message {
      max-width: 70%;
      padding: 0.875rem 1.25rem;
      border-radius: 18px;
      position: relative;
      word-wrap: break-word;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .message-user {
      background: var(--user-msg);
      color: white;
      border-bottom-right-radius: 6px;
      margin-left: auto;
    }

    .message-bot {
      background: white;
      color: var(--dark-gray);
      border: 1px solid var(--border-color);
      border-bottom-left-radius: 6px;
      margin-right: auto;
    }

    .message-content {
      line-height: 1.5;
    }

    .message-time {
      font-size: 0.75rem;
      opacity: 0.7;
      margin-top: 0.5rem;
    }

    .typing-indicator {
      display: flex;
      align-items: center;
      gap: 0.8rem;
      padding: 1.2rem 1.5rem;
      background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
      border-radius: 20px 20px 5px 20px;
      max-width: 200px;
      margin-bottom: 1rem;
      opacity: 0;
      animation: slideInBot 0.4s ease-out forwards;
      box-shadow: 0 6px 20px rgba(240, 147, 251, 0.4);
      border: 2px solid rgba(255, 255, 255, 0.2);
    }

    @keyframes slideInBot {
      0% { 
        opacity: 0; 
        transform: translateY(20px) scale(0.9);
      }
      100% { 
        opacity: 1; 
        transform: translateY(0) scale(1);
      }
    }

    .typing-dots {
      display: flex;
      gap: 6px;
    }

    .typing-dot {
      width: 10px;
      height: 10px;
      background: rgba(255, 255, 255, 0.9);
      border-radius: 50%;
      animation: typingPulse 1.4s infinite ease-in-out;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .typing-dot:nth-child(1) { animation-delay: -0.32s; }
    .typing-dot:nth-child(2) { animation-delay: -0.16s; }
    .typing-dot:nth-child(3) { animation-delay: 0s; }

    .typing-text {
      color: white;
      font-weight: 500;
      font-size: 0.9rem;
      text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    @keyframes typingPulse {
      0%, 80%, 100% { 
        transform: scale(0.4);
        opacity: 0.3;
      }
      40% { 
        transform: scale(1);
        opacity: 1;
      }
    }

    .input-area {
      background: white;
      border-top: 1px solid var(--border-color);
      padding: 1.5rem;
      border-radius: 0 0 20px 20px;
      position: sticky;
      bottom: 0; /* reste visible en bas */
      z-index: 1040; /* sous le header mais au-dessus du contenu */
      padding-bottom: calc(1.5rem + env(safe-area-inset-bottom, 0px));
    }

    .input-group {
      background: var(--secondary-light);
      border-radius: 25px;
      padding: 0.5rem;
      border: 2px solid transparent;
      transition: all 0.3s ease;
    }

    .input-group:focus-within {
      border-color: var(--primary-pink);
      box-shadow: 0 0 0 0.25rem rgba(208, 17, 104, 0.1);
    }

    .form-control {
      border: none;
      background: transparent;
      padding: 0.75rem 1rem;
      font-size: 1rem;
    }

    .form-control:focus {
      box-shadow: none;
      background: transparent;
    }

    .btn-send {
      background: var(--primary-pink);
      border: none;
      border-radius: 50%;
      width: 50px;
      height: 50px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
    }

    .btn-send:hover {
      background: #b50e5a;
      transform: scale(1.05);
    }

    .btn-send:disabled {
      opacity: 0.6;
      transform: none;
    }

    .btn-action {
      border-radius: 20px;
      padding: 0.5rem 1rem;
      font-weight: 500;
      text-decoration: none;
      transition: all 0.3s ease;
      border: 2px solid transparent;
    }

    .btn-action:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .btn-outline-primary {
      color: var(--primary-pink);
      border-color: var(--primary-pink);
    }

    .btn-outline-primary:hover {
      background: var(--primary-pink);
      border-color: var(--primary-pink);
      color: white;
    }

    .btn-sm {
      padding: 0.25rem 0.75rem;
      font-size: 0.875rem;
    }

    .empty-state {
      text-align: center;
      padding: 3rem 2rem;
      color: #6c757d;
    }

    .empty-state i {
      font-size: 3rem;
      margin-bottom: 1rem;
      opacity: 0.5;
    }

    @media (max-width: 768px) {
      .chat-container {
        height: 100vh;
        border-radius: 0;
        margin: 0;
      }
      
      .message {
        max-width: 85%;
      }
      
      .sidebar {
        position: fixed;
        left: -100%;
        top: var(--header-h); /* ne recouvre pas le header */
        width: 280px;
        height: calc(100vh - var(--header-h));
        z-index: 1020; /* sous le header */
        transition: left 0.3s ease;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        background: var(--secondary-light);
      }
      
      .sidebar.show {
        left: 0;
      }
      
      .col-md-8 {
        width: 100% !important;
      }
    }
    
    .sidebar-backdrop {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 999;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
    }
    
    .sidebar-backdrop.show {
      opacity: 1;
      visibility: visible;
    }

    .scrollbar-custom::-webkit-scrollbar {
      width: 6px;
    }

    .scrollbar-custom::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 3px;
    }

    .scrollbar-custom::-webkit-scrollbar-thumb {
      background: var(--primary-pink);
      border-radius: 3px;
    }

    .scrollbar-custom::-webkit-scrollbar-thumb:hover {
      background: #b50e5a;
    }

    .flex-1 {
      flex: 1;
    }

    /* Corrections pour la structure */
    .row.flex-1 {
      height: 100%;
    }

    .col-md-4, .col-md-8 {
      height: 100%;
    }

    /* Assurer que le contenu ne déborde pas */
    .sidebar-header {
      flex-shrink: 0;
    }

    .input-area {
      flex-shrink: 0;
    }
  </style>
</head>
<body>
  <div class="sidebar-backdrop" id="sidebar-backdrop"></div>
  
  <div class="container-fluid py-3">
    <div class="chat-container mx-auto">
      <!-- Header -->
      <div class="chat-header">
        <div class="d-flex justify-content-between align-items-center">
          <div class="d-flex align-items-center">
            <button class="btn btn-link text-white p-0 me-3 d-md-none" id="toggle-sidebar">
              <i class="bi bi-list fs-4"></i>
            </button>
            <h4 class="mb-0">
              <i class="bi bi-robot"></i>
              Nia - Assistant VIH
              <div class="status-indicator ms-2"></div>
            </h4>
          </div>
          <div class="d-flex gap-2">
            <a href="#" id="btn-back" class="btn btn-outline-light btn-action">
              <i class="bi bi-arrow-left me-1"></i>
              Retour
            </a>
          </div>
        </div>
      </div>

      <div class="row g-0 flex-1">
        <!-- Sidebar -->
        <div class="col-md-4 sidebar scrollbar-custom" id="sidebar">
          <div class="sidebar-header">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h6 class="mb-0 fw-bold">
                <i class="bi bi-chat-dots me-2"></i>
                Conversations
              </h6>
              <button class="btn btn-outline-primary btn-action btn-sm" id="new-conv">
                <i class="bi bi-plus-circle me-1"></i>
                Nouvelle
              </button>
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text bg-transparent border-0">
                <i class="bi bi-search"></i>
              </span>
              <input type="text" class="form-control border-0" placeholder="Rechercher..." id="search-conv">
            </div>
          </div>
          
          <div class="conv-list scrollbar-custom" id="conv-list">
            @forelse(($conversations ?? []) as $conv)
              <div class="conv-item" data-id="{{ data_get($conv, 'id', '') }}">
                <div class="d-flex justify-content-between align-items-start">
                  <div class="flex-grow-1">
                    <div class="fw-semibold mb-1 conv-title">{{ data_get($conv, 'title', 'Sans titre') }}</div>
                    @php($updated = data_get($conv, 'updated_at'))
                    <small class="text-muted">{{ $updated ? $updated->diffForHumans() : '' }}</small>
                  </div>
                  <div class="conv-actions">
                    <div class="dropdown">
                      <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-three-dots-vertical"></i>
                      </button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item rename-conv" href="#"><i class="bi bi-pencil me-2"></i>Renommer</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger delete-conv" href="#"><i class="bi bi-trash me-2"></i>Supprimer</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            @empty
              <div class="empty-state">
                <i class="bi bi-chat-square-dots"></i>
                <p class="mb-0">Aucune conversation</p>
                <small class="text-muted">Commencez par poser une question</small>
              </div>
            @endforelse
          </div>
        </div>

        <!-- Chat Area -->
        <div class="col-md-8 d-flex flex-column">
          <div class="messages-area scrollbar-custom" id="messages">
            <!-- Messages will be populated by JavaScript -->
          </div>

          <div class="input-area">
            <form id="chat-form">
              <input type="hidden" id="conversation_id" value="{{ (isset($conversations) && count($conversations)) ? data_get($conversations->first(), 'id', '') : '' }}" />
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Tapez votre message..." id="message" autocomplete="off">
                <button class="btn btn-send" type="submit" id="send-btn">
                  <i class="bi bi-send-fill text-white"></i>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modals -->
  <div class="modal fade" id="renameModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Renommer la conversation</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="text" class="form-control" id="new-title" placeholder="Nouveau titre">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="button" class="btn btn-primary" id="save-rename">Sauvegarder</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal de renommage -->
  <div class="modal fade" id="renameModal" tabindex="-1" aria-labelledby="renameModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="renameModalLabel">
            <i class="bi bi-pencil-square me-2"></i>Renommer la conversation
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="new-title" class="form-label">Nouveau titre</label>
            <input type="text" class="form-control" id="new-title" placeholder="Entrez le nouveau titre..." maxlength="255">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="button" class="btn btn-primary" id="save-rename">
            <i class="bi bi-check-lg me-1"></i>Sauvegarder
          </button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    class ChatBot {
      constructor() {
        this.messages = document.getElementById('messages');
        this.form = document.getElementById('chat-form');
        this.input = document.getElementById('message');
        this.convId = document.getElementById('conversation_id');
        this.sendBtn = document.getElementById('send-btn');
        this.sidebar = document.getElementById('sidebar');
        this.backdrop = document.getElementById('sidebar-backdrop');
        this.currentConvId = null;
        this.init();
      }

      init() {
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        document.getElementById('new-conv').addEventListener('click', () => this.newConversation());
        document.getElementById('toggle-sidebar')?.addEventListener('click', () => this.toggleSidebar());
        this.backdrop?.addEventListener('click', () => this.closeSidebar());
        document.getElementById('conv-list').addEventListener('click', (e) => this.handleConvClick(e));
        
        // Gestion des actions de conversation
        document.addEventListener('click', (e) => {
          if (e.target.closest('.rename-conv')) {
            e.preventDefault();
            this.renameConversation(e.target.closest('.conv-item'));
          } else if (e.target.closest('.delete-conv')) {
            e.preventDefault();
            this.deleteConversation(e.target.closest('.conv-item'));
          }
        });

        document.getElementById('save-rename').addEventListener('click', () => this.saveRename());
        
        // Initialiser avec le message de bienvenue si aucune conversation n'est active
        this.initializeWelcomeMessage();
        this.bindBackButton();
        this.updateHeaderHeight();
        window.addEventListener('resize', () => this.updateHeaderHeight());
      }

      initializeWelcomeMessage() {
        // Si aucune conversation n'est sélectionnée, afficher le message de bienvenue
        if (!this.convId.value) {
          setTimeout(() => {
            this.appendMessage(
              "Bonjour ! 😊 Je suis Nia, votre assistante virtuelle spécialisée dans l'accompagnement des personnes vivant avec le VIH.<br><br>" +
              "Je suis là pour vous aider avec :<br>" +
              "• Questions sur le VIH et les traitements<br>" +
              "• Conseils sur le bien-être et la prévention<br>" +
              "• Soutien psychologique et informations pratiques<br>" +
              "• Orientation vers des professionnels si nécessaire<br><br>" +
              "N'hésitez pas à me poser toutes vos questions ! 💖", 
              'bot'
            );
          }, 800);
        }
      }

      updateHeaderHeight() {
        const header = document.querySelector('.chat-header');
        if (header) {
          const h = header.offsetHeight;
          document.documentElement.style.setProperty('--header-h', h + 'px');
        }
      }

      toggleSidebar() {
        this.sidebar.classList.toggle('show');
        this.backdrop.classList.toggle('show');
      }

      closeSidebar() {
        this.sidebar.classList.remove('show');
        this.backdrop.classList.remove('show');
      }

      newConversation() {
        this.convId.value = '';
        this.currentConvId = null;
        this.messages.innerHTML = '';
        
        // Afficher une bulle de bienvenue de Nia
        setTimeout(() => {
          this.appendMessage(
            "Bonjour ! 😊 Je suis Nia, votre assistante virtuelle spécialisée dans l'accompagnement des personnes vivant avec le VIH.<br><br>" +
            "Je suis là pour vous aider avec :<br>" +
            "• Questions sur le VIH et les traitements<br>" +
            "• Conseils sur le bien-être et la prévention<br>" +
            "• Soutien psychologique et informations pratiques<br>" +
            "• Orientation vers des professionnels si nécessaire<br><br>" +
            "N'hésitez pas à me poser toutes vos questions ! 💖", 
            'bot'
          );
        }, 500);
        
        document.querySelectorAll('.conv-item').forEach(item => item.classList.remove('active'));
        this.closeSidebar();
      }

      async handleConvClick(e) {
        const convItem = e.target.closest('.conv-item');
        if (!convItem || e.target.closest('.dropdown')) return;
        
        const convId = convItem.getAttribute('data-id');
        if (!convId) return;

        document.querySelectorAll('.conv-item').forEach(item => item.classList.remove('active'));
        convItem.classList.add('active');
        
        this.convId.value = convId;
        this.currentConvId = convId;
        this.closeSidebar();
        
        await this.loadConversationHistory(convId);
      }

      async loadConversationHistory(convId) {
        this.messages.innerHTML = '<div class="text-center p-4"><div class="spinner-border text-primary" role="status"></div></div>';
        
        try {
          const response = await fetch(`/assistant/conversation/${convId}/messages`);
          if (response.ok) {
            const data = await response.json();
            this.displayMessages(data.messages || []);
          } else {
            throw new Error('Erreur de chargement');
          }
        } catch (error) {
          this.messages.innerHTML = `
            <div class="empty-state">
              <i class="bi bi-exclamation-triangle text-warning"></i>
              <p class="mb-0">Erreur lors du chargement de la conversation</p>
            </div>
          `;
        }
      }

      displayMessages(messages) {
        this.messages.innerHTML = '';
        messages.forEach(msg => {
          if (msg.is_from_user) {
            this.appendMessage(msg.message, 'user', msg.created_at);
          }
          if (msg.response) {
            this.appendMessage(msg.response, 'bot', msg.created_at);
          }
        });
        this.scrollToBottom();
      }

      appendMessage(text, sender = 'bot', timestamp = null) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message-wrapper d-flex ${sender === 'user' ? 'justify-content-end' : ''}`;
        
        const time = timestamp ? new Date(timestamp).toLocaleTimeString('fr-FR', {hour: '2-digit', minute: '2-digit'}) : 
                    new Date().toLocaleTimeString('fr-FR', {hour: '2-digit', minute: '2-digit'});
        
        messageDiv.innerHTML = `
          <div class="message message-${sender}">
            <div class="message-content">${text}</div>
            <div class="message-time">${time}</div>
          </div>
        `;
        
        this.messages.appendChild(messageDiv);
        this.scrollToBottom();
      }

      showTyping() {
        const typingDiv = document.createElement('div');
        typingDiv.className = 'typing-indicator';
        typingDiv.id = 'typing';
        typingDiv.innerHTML = `
          <div class="typing-dots">
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
          </div>
          <small class="text-muted ms-2">Nia écrit...</small>
        `;
        this.messages.appendChild(typingDiv);
        this.scrollToBottom();
      }

      hideTyping() {
        const typing = document.getElementById('typing');
        if (typing) typing.remove();
      }

      async handleSubmit(e) {
        e.preventDefault();
        const text = this.input.value.trim();
        if (!text) return;

        this.appendMessage(text, 'user');
        this.input.value = '';
        this.sendBtn.disabled = true;
        this.showTyping();

        try {
          const response = await fetch('/assistant/chat', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
            },
            body: JSON.stringify({
              message: text,
              conversation_id: this.convId.value || null
            })
          });

          const data = await response.json();
          this.hideTyping();

          if (data?.response) {
            this.appendMessage(data.response, 'bot');
            if (data?.conversation_id) {
              this.convId.value = data.conversation_id;
              this.currentConvId = data.conversation_id;
              // Recharger la liste des conversations si c'est une nouvelle
              if (!this.currentConvId) {
                setTimeout(() => location.reload(), 1000);
              }
            }
          } else {
            this.appendMessage(data?.error || 'Erreur de communication', 'bot');
          }
        } catch (error) {
          this.hideTyping();
          this.appendMessage('Erreur de réseau. Veuillez réessayer.', 'bot');
        } finally {
          this.sendBtn.disabled = false;
        }
      }

      scrollToBottom() {
        setTimeout(() => {
          this.messages.scrollTop = this.messages.scrollHeight;
        }, 100);
      }

      renameConversation(convItem) {
        const currentTitle = convItem.querySelector('.conv-title').textContent;
        document.getElementById('new-title').value = currentTitle;
        this.renameConvId = convItem.getAttribute('data-id');
        new bootstrap.Modal(document.getElementById('renameModal')).show();
      }

      async saveRename() {
        const newTitle = document.getElementById('new-title').value.trim();
        if (!newTitle || !this.renameConvId) return;

        try {
          const response = await fetch(`/assistant/conversation/${this.renameConvId}/rename`, {
            method: 'PATCH',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
            },
            body: JSON.stringify({ title: newTitle })
          });

          if (response.ok) {
            const convItem = document.querySelector(`[data-id="${this.renameConvId}"]`);
            if (convItem) {
              convItem.querySelector('.conv-title').textContent = newTitle;
            }
            bootstrap.Modal.getInstance(document.getElementById('renameModal')).hide();
          }
        } catch (error) {
          console.error('Erreur lors du renommage:', error);
        }
      }

      async deleteConversation(convItem) {
        if (!confirm('Êtes-vous sûr de vouloir supprimer cette conversation ?')) return;
        
        const convId = convItem.getAttribute('data-id');
        try {
          const response = await fetch(`/assistant/conversation/${convId}`, {
            method: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
            }
          });

          if (response.ok) {
            convItem.remove();
            if (this.currentConvId === convId) {
              this.newConversation();
            }
          }
        } catch (error) {
          console.error('Erreur lors de la suppression:', error);
        }
      }

      bindBackButton() {
        const backBtn = document.getElementById('btn-back');
        if (!backBtn) return;
        backBtn.addEventListener('click', (e) => {
          e.preventDefault();
          if (window.history.length > 1) {
            window.history.back();
          } else {
            window.location.href = document.referrer || '/assistant';
          }
        });
      }
    }

    // Initialiser le chatbot
    document.addEventListener('DOMContentLoaded', () => {
      new ChatBot();
    });
  </script>
</body>
</html>
