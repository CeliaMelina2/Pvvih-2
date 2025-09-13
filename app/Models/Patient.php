<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Patient extends Authenticatable
{
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'sexe',
        'telephone',
        'adresse',
        'statut_serologique',
        'date_diagnostic',
        'codeTARV',
    ];

    protected $hidden = [
        'password',
    ];
}
