<?php

namespace Database\Seeders;

use App\Models\MaterialAceito;
use App\Models\Ong;
use App\Models\PontoDeColeta;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OngSeeder extends Seeder
{
    
    public function run(): void
    {
        $usuario = User::updateOrCreate(
            ['email' => 'ong@ecopoint.com'],
            [
                'name' => 'ONG Esperança Viva',
                'password' => Hash::make('ong123'),
                'role' => 'ong',
            ]
        );

        $ong = Ong::updateOrCreate(
            ['user_id' => $usuario->id],
            [
                'nome' => 'ONG Esperança Viva',
                'cnpj' => '12.345.678/0001-90',
                'telefone' => '(11) 98765-4321',
                'email_contato' => 'contato@esperancaviva.org',
                'descricao' => 'Instituição sem fins lucrativos dedicada à arrecadação e redistribuição de livros escolares e acadêmicos para estudantes.',
                'ativo' => true,
            ]
        );

        $ponto = PontoDeColeta::updateOrCreate(
            [
                'ong_id' => $ong->id,
                'nome' => 'Ponto Central - Biblioteca Comunitária',
            ],
            [
                'descricao' => 'Ponto principal de doação e retirada de materiais didáticos.',
                'cep' => '01310-100',
                'endereco' => 'Avenida Paulista',
                'numero' => '1000',
                'complemento' => 'Sala 102',
                'bairro' => 'Bela Vista',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'latitude' => -23.56573400,
                'longitude' => -46.65125700,
                'horario_funcionamento' => 'Segunda a Sexta, das 09h às 17h',
                'telefone_contato' => '(11) 98765-4321',
                'ativo' => true,
            ]
        );

        $materiais = MaterialAceito::pluck('id');
        if ($materiais->isNotEmpty()) {
            $ponto->materiaisAceitos()->sync($materiais);
        }
    }
}

