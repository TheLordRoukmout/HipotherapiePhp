<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rendez_vous_poney', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rendez_vous_id')
                ->constrained('rendez_vous') // Spécifier explicitement la table "rendez_vous" sinon erreur rendez-vouses
                ->onDelete('cascade');
        
            $table->foreignId('poney_id')
                ->constrained('poneys') // S'assurer que "poneys" est correct
                ->onDelete('cascade');
        
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('rendez_vous_poney');
    }
};
