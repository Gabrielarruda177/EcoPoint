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
        // Tabela intermediária (pivot) relacionando Pontos de Coleta e Materiais Aceitos (N:N)
        Schema::create('material_ponto_coleta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ponto_de_coleta_id')->constrained('pontos_de_coleta')->onDelete('cascade');
            $table->foreignId('material_aceito_id')->constrained('materiais_aceitos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_ponto_coleta');
    }
};
