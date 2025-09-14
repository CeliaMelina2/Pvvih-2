<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
   Schema::create('patients', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->string('nom');
        $table->string('prenom');
        $table->string('sexe');
        $table->string('telephone');
        $table->string('adresse');
        $table->string('statut_serologique');
        $table->date('date_diagnostic');
        $table->string('codeTARV');
        $table->string('attestation')->nullable(); // si tu stockes un fichier
        $table->timestamps();
    });


}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
