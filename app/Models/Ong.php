<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ong extends Model
{
    use HasFactory;

    /**
     * Nome explícito da tabela no banco de dados.
     */
    protected $table = 'ongs';

    /**
     * Atributos que podem ser preenchidos em massa.
     */
    protected $fillable = [
        'user_id',
        'nome',
        'cnpj',
        'telefone',
        'email_contato',
        'descricao',
        'cep',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'ativo',
    ];

    /**
     * Conversões de tipo dos atributos.
     */
    protected function casts(): array
    {
        return [
            'ativo' => 'boolean',
        ];
    }

    /**
     * Relacionamento: A ONG pertence a um Usuário (responsável pelo login).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento: A ONG possui vários pontos de coleta cadastrados.
     */
    public function pontosDeColeta(): HasMany
    {
        return $this->hasMany(PontoDeColeta::class);
    }
}
