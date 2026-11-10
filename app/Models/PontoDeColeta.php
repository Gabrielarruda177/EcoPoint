<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PontoDeColeta extends Model
{
    use HasFactory;

    /**
     * Nome explícito da tabela no banco de dados.
     */
    protected $table = 'pontos_de_coleta';

    /**
     * Atributos que podem ser preenchidos em massa.
     */
    protected $fillable = [
        'ong_id',
        'nome',
        'descricao',
        'cep',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'latitude',
        'longitude',
        'horario_funcionamento',
        'telefone_contato',
        'ativo',
    ];

    /**
     * Conversões de tipo dos atributos.
     */
    protected function casts(): array
    {
        return [
            'ativo' => 'boolean',
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    /**
     * Relacionamento: O Ponto de Coleta pertence a uma ONG.
     */
    public function ong(): BelongsTo
    {
        return $this->belongsTo(Ong::class);
    }

    /**
     * Relacionamento: O Ponto de Coleta aceita vários tipos de materiais (N:N).
     */
    public function materiaisAceitos(): BelongsToMany
    {
        return $this->belongsToMany(
            MaterialAceito::class,
            'material_ponto_coleta',
            'ponto_de_coleta_id',
            'material_aceito_id'
        )->withTimestamps();
    }
}

