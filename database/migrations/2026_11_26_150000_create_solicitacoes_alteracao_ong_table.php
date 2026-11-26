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
        Schema::create('solicitacoes_alteracao_ong', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ong_id')->constrained('ongs')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('tipo', 20); // 'nome' ou 'endereco'
            $table->json('dados_atuais');
            $table->json('dados_propostos');
            $table->text('justificativa')->nullable();
            $table->string('status', 20)->default('pendente'); // 'pendente', 'aprovada', 'recusada'
            $table->text('motivo_recusa')->nullable();
            $table->timestamp('analisado_em')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitacoes_alteracao_ong');
    }
};
