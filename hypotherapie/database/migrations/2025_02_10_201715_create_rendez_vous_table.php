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
        Schema::create('rendez_vous', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade'); // Relation avec le client
            $table->foreignId('poney_id')->constrained()->onDelete('cascade'); // Relation avec le poney
            $table->dateTime('date_heure'); // Date et heure du rendez-vous
            $table->dateTime('date_heure_fin')->after('date_heure');
            $table->integer('nombre_personnes'); // Nombre de personnes pour le rendez-vous
            $table->timestamps(); // Ajoute created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rendez_vous');
    }
};
