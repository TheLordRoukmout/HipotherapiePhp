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
        Schema::table('factures', function (Blueprint $table) {
            if (!Schema::hasColumn('factures', 'rendez_vous_id')) {
                $table->foreignId('rendez_vous_id')->nullable()->constrained('rendez_vous')->onDelete('cascade');
            }
        });
    }
    
    public function down()
    {
        Schema::table('factures', function (Blueprint $table) {
            if (Schema::hasColumn('factures', 'rendez_vous_id')) {
                $table->dropForeign(['rendez_vous_id']);
                $table->dropColumn('rendez_vous_id');
            }
        });
    }
    
    
};
