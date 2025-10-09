<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transferts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('centre_id')->nullable()->constrained('centres');
            $table->foreignId('aps_id')->nullable()->constrained('aps');
            $table->dateTime('date_heure');
            $table->string('motif');
            $table->string('dossier');
            $table->enum('statut', ['en_attente', 'valide', 'refuse', 'en_cours'])->default('en_attente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transferts');
    }
};
