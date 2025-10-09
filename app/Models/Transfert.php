<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfert extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'aps_id', 
        'centre_id',
        'date_heure',
        'motif',
        'dossier', 
        'statut',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function aps()
    {
        return $this->belongsTo(Aps::class);
    }

    public function centres()
    {
        return $this->belongsTo(Centre::class);
    }
}