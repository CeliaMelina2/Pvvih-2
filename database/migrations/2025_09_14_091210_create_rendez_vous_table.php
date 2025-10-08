<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRendezVousTable extends Migration
{
    public function up()
    {
        Schema::create('rendez_vous', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('aps_id');
            $table->foreign('aps_id')->references('idAPS')->on('aps')->onDelete('cascade');
            $table->string('medecin_nom');
            $table->dateTime('date_heure');
            $table->string('motif');
            $table->string('statut')->default('En attente'); // Confirmé, En attente, Annulé, Terminé
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rendez_vous');
    }
}
