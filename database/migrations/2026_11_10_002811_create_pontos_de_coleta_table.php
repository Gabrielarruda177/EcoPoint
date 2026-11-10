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
        Schema::create('pontos_de_coleta', function (Blueprint $table) {
            $table->id();
            // Vincula o ponto de coleta à ONG responsável
            $table->foreignId('ong_id')->constrained('ongs')->onDelete('cascade');
            $table->string('nome');
            $table->text('descricao')->nullable();
            
            // Dados de localização / endereço
            $table->string('cep', 9)->nullable();
            $table->string('endereco');
            $table->string('numero', 20)->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade');
            $table->string('estado', 2);
            
            // Coordenadas opcionais preparadas para futura integração com mapa
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // Informações de contato e funcionamento
            $table->string('horario_funcionamento')->nullable();
            $table->string('telefone_contato', 20)->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pontos_de_coleta');
    }
};
