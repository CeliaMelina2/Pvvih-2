<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Patient extends Authenticatable
{
    protected $table = 'patients'; 
      use Notifiable;

    protected $fillable = [
        'nom',
        'prenom',
        'sexe',
        'telephone',
        'adresse',
        'statut_serologique',
        'attestation',
        'date_diagnostic',
        'codeTARV',
        'user_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function rendez_vous()
    {
        return $this->hasMany(RendezVous::class);
    }
    

    public function traitements()
    {
        return $this->hasMany(Traitement::class);
    }

    public function dossierMedical()
    {
        return $this->hasMany(DossierMedical::class);
    }

    public function aps()
    {
        return $this->belongsTo(Aps::class);
    }

    public function transfert()
    {
        return $this->hasOne(Transfert::class);
    }
}
