<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PatientDashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ApsController;

// Page d’accueil
Route::get('/', [AuthController::class, 'accueil'])->name('accueil');

// Page inscription générale (choix Patient ou APS)
Route::get('/inscription', function () {
    return view('inscription'); // Vue avec les 2 boutons Patient / APS
})->name('inscription');

// ===================== INSCRIPTION =====================

// Inscription Patient
Route::get('/inscription/patient', [RegisterController::class, 'showPatientForm'])->name('inscription.patient');
Route::post('/inscription/patient', [RegisterController::class, 'registerPatient']);

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

// Dashboard Patient (seulement pour utilisateurs connectés)
Route::get('/patient/dashboard', [PatientDashboardController::class, 'index'])
    ->name('patient.dashboard');
// ===================== REDIRECTION LARAVEL PAR DÉFAUT =====================
Route::get('/login', function () {
    return redirect()->route('connexion');
})->name('login');

// ===================== CRUD =====================
// Route::resource('patients', PatientController::class);
// Route::resource('aps', ApsController::class);
