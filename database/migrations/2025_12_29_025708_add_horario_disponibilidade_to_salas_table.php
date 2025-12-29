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
        Schema::table('salas', function (Blueprint $table) {
            $table->time('horario_abertura')->default('08:00:00')->after('localizacao');
            $table->time('horario_fechamento')->default('18:00:00')->after('horario_abertura');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('salas', function (Blueprint $table) {
            $table->dropColumn(['horario_abertura', 'horario_fechamento']);
        });
    }
};
