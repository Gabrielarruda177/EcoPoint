<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MaterialAceito extends Model
{
    use HasFactory;

    /**
     * Nome explícito da tabela no banco de dados.
     */
    protected $table = 'materiais_aceitos';

    /**
     * Atributos que podem ser preenchidos em massa.
     */
    protected $fillable = [
        'nome',
        'descricao',
    ];

    /**
     * Relacionamento: O Material pode ser aceito por vários pontos de coleta (N:N).
     */
    public function pontosDeColeta(): BelongsToMany
    {
        return $this->belongsToMany(
            PontoDeColeta::class,
            'material_ponto_coleta',
            'material_aceito_id',
            'ponto_de_coleta_id'
        )->withTimestamps();
    }
}

