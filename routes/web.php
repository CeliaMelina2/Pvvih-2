<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UsersController;


use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PatientDashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ApsController;
use App\Http\Controllers\TransfertController;
use App\Http\Controllers\TraitementApsController;



use App\Http\Controllers\Patient\DashboardController;
use App\Http\Controllers\Patient\RendezVousController;
use App\Http\Controllers\Patient\TraitementController;
use App\Http\Controllers\Patient\TraitementAdminController;


use App\Http\Controllers\Patient\DossierMedicalController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Patient\MessagesController;
use App\Http\Controllers\ApsAdminController;
use App\Http\Controllers\PatientAdminController;
use App\Http\Controllers\RapportController;


use App\Http\Controllers\Patient\ProfilController;
use App\Http\Controllers\ChatbotController;



Route::get('/', [AuthController::class, 'accueil'])->name('accueil');

Route::get('/inscription', function () {
    return view('inscription'); 
})->name('inscription');


Route::get('/inscription/patient', [RegisterController::class, 'showPatientForm'])->name('affiche.inscription.patient');
Route::post('/inscription/patient', [RegisterController::class, 'registerPatient'])->name('inscription.patient');

Route::get('/inscription/aps', [ApsController::class, 'create'])->name('inscription.aps');
Route::post('/inscription/aps', [ApsController::class, 'store'])->name('inscription.aps.store');


Route::get('/connexion', [RegisterController::class, 'showLoginForm'])->name('connexion');
Route::post('/connexion', [RegisterController::class, 'login'])->name('connexion.submit');


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/login', function () {
    return redirect()->route('connexion');
})->name('login');


Route::middleware(['role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/rendezvous', [RendezVousController::class, 'index'])->name('rendezvous');
    Route::post('/rendezvous/store', [RendezVousController::class, 'store'])->name('rendezvous.store');
    Route::post('/rendezvous/annuler/{id}', [RendezVousController::class, 'cancel'])->name('rendezvous.cancel');

    Route::get('/traitements', [TraitementController::class, 'index'])->name('traitement');
    Route::post('/traitements/marquer-pris/{id}', [TraitementController::class, 'marquerPris'])->name('traitements.marquer_pris');

    Route::get('/dossier-medical', [TransfertController::class, 'index'])->name('dossier_medical');
    Route::post('/transfert/store', [TransfertController::class, 'store'])->name('transfert.store');
    Route::post('/transfert/annuler/{id}', [TransfertController::class, 'cancel'])->name('transfert.cancel');


    Route::get('/messages', [MessagesController::class, 'index'])->name('message');
    Route::post('/messages/envoyer', [MessagesController::class, 'store'])->name('messages.store');

    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
    Route::post('/profil/update-info', [ProfilController::class, 'updateInfo'])->name('profil.update_info');
    Route::post('/profil/update-sante', [ProfilController::class, 'updateSante'])->name('profil.update_sante');
    Route::post('/profil/update-password', [ProfilController::class, 'updatePassword'])->name('profil.update_password');

     Route::get('/assistant', [ChatbotController::class, 'view'])->name('assistant.view');
        Route::post('/assistant/chat', [ChatbotController::class, 'chat'])->name('assistant.chat');
        Route::get('/assistant/conversation/{id}/messages', [ChatbotController::class, 'getConversationMessages'])->name('assistant.conversation.messages');
        Route::patch('/assistant/conversation/{id}/rename', [ChatbotController::class, 'renameConversation'])->name('assistant.conversation.rename');
        Route::delete('/assistant/conversation/{id}', [ChatbotController::class, 'deleteConversation'])->name('assistant.conversation.delete');
});


// Routes Admin
Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Gestion des utilisateurs
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
    Route::post('/users', [UsersController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UsersController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');
    
    Route::get('/patients', [PatientAdminController::class, 'index'])->name('patients.index');    
    Route::get('/aps', [ApsAdminController::class, 'index'])->name('aps.index');

    // Rendez-vous
    Route::get('/rendezvous', [RendezVousController::class, 'index'])->name('rendezvous.index');
    
    // Traitements
    Route::get('/traitements', [TraitementAdminController::class, 'index'])->name('traitements.index');
    
    // Messages
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    
    // Rapports
    Route::get('/rapports', [RapportController::class, 'index'])->name('rapports.index');
    
    // Paramètres
    Route::get('/parametres', [AdminController::class, 'parametres'])->name('parametres');
    Route::get('/profil', [AdminController::class, 'profil'])->name('profil');

     Route::get('/assistant', [ChatbotController::class, 'view'])->name('assistant.view');
        Route::post('/assistant/chat', [ChatbotController::class, 'chat'])->name('assistant.chat');
        Route::get('/assistant/conversation/{id}/messages', [ChatbotController::class, 'getConversationMessages'])->name('assistant.conversation.messages');
        Route::patch('/assistant/conversation/{id}/rename', [ChatbotController::class, 'renameConversation'])->name('assistant.conversation.rename');
        Route::delete('/assistant/conversation/{id}', [ChatbotController::class, 'deleteConversation'])->name('assistant.conversation.delete');
});

    Route::middleware(['role:aps'])->prefix('aps')->name('aps.')->group(function () {


        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/stats', [DashboardController::class, 'getStats'])->name('stats');

        Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
        Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
        Route::put('/patients/{id}', [PatientController::class, 'update'])->name('patients.update');
        Route::delete('/patients/{id}', [PatientController::class, 'destroy'])->name('patients.destroy');
        Route::post('/patients/{id}/traitements', [PatientController::class, 'assignTraitement'])->name('patients.traitement');

        Route::get('/rendezvous', [RendezVousController::class, 'indexaps'])->name('rendezvous.index');
        Route::post('/rendezvous', [RendezVousController::class, 'storeaps'])->name('rendezvous.store');
        Route::put('/rendezvous/{id}', [RendezVousController::class, 'update'])->name('rendezvous.update');
        Route::delete('/rendezvous/{id}', [RendezVousController::class, 'destroy'])->name('rendezvous.destroy');
        Route::patch('/rendezvous/{id}/status', [RendezVousController::class, 'updateStatus'])->name('rendezvous.status');

});

    Route::middleware('auth')->group(function () {
        Route::get('/assistant', [ChatbotController::class, 'view'])->name('assistant.view');
        Route::post('/assistant/chat', [ChatbotController::class, 'chat'])->name('assistant.chat');
        Route::get('/assistant/conversation/{id}/messages', [ChatbotController::class, 'getConversationMessages'])->name('assistant.conversation.messages');
        Route::patch('/assistant/conversation/{id}/rename', [ChatbotController::class, 'renameConversation'])->name('assistant.conversation.rename');
        Route::delete('/assistant/conversation/{id}', [ChatbotController::class, 'deleteConversation'])->name('assistant.conversation.delete');
    });