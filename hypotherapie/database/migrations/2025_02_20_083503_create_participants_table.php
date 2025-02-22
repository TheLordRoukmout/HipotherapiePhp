<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rendez_vous_id')
                ->constrained('rendez_vous') // Forcer le bon nom de la table
                ->onDelete('cascade');

            $table->string('nom'); // Nom du participant
            $table->foreignId('poney_id')
                ->constrained('poneys') // Vérifier que "poneys" est bien le bon nom
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('participants');
    }
};
