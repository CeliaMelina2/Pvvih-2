<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DossierMedical extends Model
{
    use HasFactory;
    
    // Le nom de la table est 'dossier_medicals'
    protected $table = 'dossier_medicals';

    protected $fillable = [
        'patient_id',
        'date_consultation',
        'medecin_aps_nom',
        'motif_consultation',
        'notes',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
