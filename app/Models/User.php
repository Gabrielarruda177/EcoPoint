<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Os atributos que podem ser atribuídos em massa.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 'admin' ou 'ong'
    ];

    /**
     * Os atributos ocultos na serialização.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Os atributos que devem ser convertidos (cast).
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relacionamento: Um usuário institucional possui uma ONG associada.
     */
    public function ong(): HasOne
    {
        return $this->hasOne(Ong::class);
    }

    /**
     * Verifica se o usuário possui perfil de Administrador.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Verifica se o usuário possui perfil de ONG.
     */
    public function isOng(): bool
    {
        return $this->role === 'ong';
    }
}
