<?php

namespace Database\Seeders;

use App\Models\MaterialAceito;
use Illuminate\Database\Seeder;

class MaterialAceitoSeeder extends Seeder
{
   
    public function run(): void
    {
        $materiais = [
            [
                'nome' => 'Livros Didáticos (Ensino Fundamental / Médio)',
                'descricao' => 'Livros escolares de disciplinas básicas como Matemática, Português, História, Geografia, etc.',
            ],
            [
                'nome' => 'Apostilas Pré-Vestibular / ENEM',
                'descricao' => 'Materiais preparatórios para exames vestibulares e concursos.',
            ],
            [
                'nome' => 'Livros Universitários / Acadêmicos',
                'descricao' => 'Obras de graduação e pós-graduação das áreas de Exatas, Humanas, Biológicas e Tecnológicas.',
            ],
            [
                'nome' => 'Livros Literários / Paradidáticos',
                'descricao' => 'Literatura nacional, estrangeira e leituras obrigatórias escolares.',
            ],
            [
                'nome' => 'Dicionários e Enciclopédias',
                'descricao' => 'Materiais de apoio e consulta para pesquisa e estudo.',
            ],
        ];

        foreach ($materiais as $material) {
            MaterialAceito::firstOrCreate(
                ['nome' => $material['nome']],
                ['descricao' => $material['descricao']]
            );
        }
    }
}
