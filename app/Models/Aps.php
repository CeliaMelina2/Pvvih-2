<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Aps extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'aps';

    protected $fillable = [
        'nom',
        'user_id',
        'prenom',
        'sexe',
        'telephone',
        'adresse',
        'email',
        'password',
        'attestation_fonction',
        'specialite',
        'statut',
        'matricule',
        'hopital',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function patients()
    {
        return $this->hasMany(Patient::class, 'aps_id');
    }

    public function rendez_vous()
    {
        return $this->hasMany(RendezVous::class, 'aps_id');
    }
      public function traitements()
    {
        return $this->hasManyThrough(
            Traitement::class, // Modèle cible
            Patient::class,    // Modèle intermédiaire
            'patient_id',      // clé étrangère dans Traitement
            'id',              // clé locale dans Aps
            'id'               // clé locale dans Patient
        );
    }
}