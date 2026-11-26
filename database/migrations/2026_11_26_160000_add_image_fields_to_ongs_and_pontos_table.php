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
        Schema::table('ongs', function (Blueprint $table) {
            $table->string('logo')->nullable()->after('descricao');
        });

        Schema::table('pontos_de_coleta', function (Blueprint $table) {
            $table->string('imagem')->nullable()->after('descricao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ongs', function (Blueprint $table) {
            $table->dropColumn('logo');
        });

        Schema::table('pontos_de_coleta', function (Blueprint $table) {
            $table->dropColumn('imagem');
        });
    }
};
