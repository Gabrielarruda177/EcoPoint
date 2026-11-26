<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolicitacaoAlteracaoOng extends Model
{
    use HasFactory;

    protected $table = 'solicitacoes_alteracao_ong';

    protected $fillable = [
        'ong_id',
        'user_id',
        'tipo',
        'dados_atuais',
        'dados_propostos',
        'justificativa',
        'status',
        'motivo_recusa',
        'analisado_em',
    ];

    protected function casts(): array
    {
        return [
            'dados_atuais' => 'array',
            'dados_propostos' => 'array',
            'analisado_em' => 'datetime',
        ];
    }

    public function ong(): BelongsTo
    {
        return $this->belongsTo(Ong::class, 'ong_id');
    }

    public function analisadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isPendente(): bool
    {
        return $this->status === 'pendente';
    }

    public function isAprovada(): bool
    {
        return $this->status === 'aprovada';
    }

    public function isRecusada(): bool
    {
        return $this->status === 'recusada';
    }

    public function getTipoLabelAttribute(): string
    {
        return match ($this->tipo) {
            'nome' => 'Nome da Instituição',
            'endereco' => 'Endereço e Localização',
            default => ucfirst($this->tipo),
        };
    }
}
