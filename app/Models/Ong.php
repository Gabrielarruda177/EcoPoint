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
        'logo',
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
     * Retorna a URL completa da logo da ONG ou null caso não possua.
     */
    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
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

    /**
     * Relacionamento: Solicitações de alteração de dados cadastrais (nome, endereço).
     */
    public function solicitacoesAlteracao(): HasMany
    {
        return $this->hasMany(SolicitacaoAlteracaoOng::class, 'ong_id');
    }
}
