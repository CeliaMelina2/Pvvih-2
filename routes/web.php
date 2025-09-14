<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PatientDashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ApsController;


use App\Http\Controllers\Patient\DashboardController;
use App\Http\Controllers\Patient\RendezVousController;
use App\Http\Controllers\Patient\TraitementController;
use App\Http\Controllers\Patient\DossierMedicalController;
use App\Http\Controllers\Patient\MessagesController;
use App\Http\Controllers\Patient\ProfilController;


// Page d’accueil
Route::get('/', [AuthController::class, 'accueil'])->name('accueil');

// Page inscription générale (choix Patient ou APS)
Route::get('/inscription', function () {
    return view('inscription'); // Vue avec les 2 boutons Patient / APS
})->name('inscription');

// ===================== INSCRIPTION =====================

// Inscription Patient
Route::get('/inscription/patient', [RegisterController::class, 'showPatientForm'])->name('affiche.inscription.patient');
Route::post('/inscription/patient', [RegisterController::class, 'registerPatient'])->name('inscription.patient');

// Inscription APS
Route::get('/inscription/aps', [ApsController::class, 'create'])->name('inscription.aps');
Route::post('/inscription/aps', [ApsController::class, 'store'])->name('inscription.aps.store');

// ===================== CONNEXION =====================

// Connexion (générale)
Route::get('/connexion', [RegisterController::class, 'showLoginForm'])->name('connexion');
Route::post('/connexion', [RegisterController::class, 'login'])->name('connexion.submit');


// Déconnexion
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===================== DASHBOARD =====================

// ===================== REDIRECTION LARAVEL PAR DÉFAUT =====================
Route::get('/login', function () {
    return redirect()->route('connexion');
})->name('login');

// ===================== CRUD =====================
// Route::resource('patients', PatientController::class);
// Route::resource('aps', ApsController::class);


// route du  Dashboard patient
Route::middleware(['role:patient'])->prefix('patient')->name('patient.')->group(function () {


      // Tableau de bord
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rendez-vous
    Route::get('/rendezvous', [RendezVousController::class, 'index'])->name('rendezvous');
    Route::post('/rendezvous/prendre', [RendezVousController::class, 'store'])->name('rendezvous.store');
    Route::post('/rendezvous/annuler/{id}', [RendezVousController::class, 'cancel'])->name('rendezvous.cancel');

    // Traitements
    Route::get('/traitements', [TraitementController::class, 'index'])->name('traitement');
    Route::post('/traitements/marquer-pris/{id}', [TraitementController::class, 'marquerPris'])->name('traitements.marquer_pris');

    // Dossier médical
    Route::get('/dossier-medical', [DossierMedicalController::class, 'index'])->name('dossier_medical');

    // Messages
    Route::get('/messages', [MessagesController::class, 'index'])->name('message');
    Route::post('/messages/envoyer', [MessagesController::class, 'store'])->name('messages.store');

    // Profil
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
    Route::post('/profil/update-info', [ProfilController::class, 'updateInfo'])->name('profil.update_info');
    Route::post('/profil/update-sante', [ProfilController::class, 'updateSante'])->name('profil.update_sante');
    Route::post('/profil/update-password', [ProfilController::class, 'updatePassword'])->name('profil.update_password');

});