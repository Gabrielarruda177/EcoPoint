<?php

namespace Database\Seeders;

use App\Models\MaterialAceito;
use App\Models\Ong;
use App\Models\PontoDeColeta;
use App\Models\SolicitacaoAlteracaoOng;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CargaMassivaOngSeeder extends Seeder
{
    /**
     * Gera 150 ONGs com dados brasileiros realistas e dezenas de solicitações
     * de alteração com status pendente, aprovada e recusada.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $materiais = MaterialAceito::all();
        $defaultPassword = Hash::make('ong123');

        // Cidades e estados brasileiros distribuídos
        $cidades = [
            ['cidade' => 'São Paulo', 'estado' => 'SP', 'cep' => '01310-200', 'bairro' => 'Bela Vista', 'rua' => 'Avenida Paulista'],
            ['cidade' => 'Campinas', 'estado' => 'SP', 'cep' => '13010-000', 'bairro' => 'Centro', 'rua' => 'Rua Barão de Jaguara'],
            ['cidade' => 'Santos', 'estado' => 'SP', 'cep' => '11010-010', 'bairro' => 'Gonzaga', 'rua' => 'Avenida Ana Costa'],
            ['cidade' => 'Ribeirão Preto', 'estado' => 'SP', 'cep' => '14010-000', 'bairro' => 'Centro', 'rua' => 'Rua Álvares Cabral'],
            ['cidade' => 'Rio de Janeiro', 'estado' => 'RJ', 'cep' => '20040-000', 'bairro' => 'Centro', 'rua' => 'Avenida Rio Branco'],
            ['cidade' => 'Niterói', 'estado' => 'RJ', 'cep' => '24210-000', 'bairro' => 'Icaraí', 'rua' => 'Rua Gavião Peixoto'],
            ['cidade' => 'Belo Horizonte', 'estado' => 'MG', 'cep' => '30130-000', 'bairro' => 'Savassi', 'rua' => 'Avenida Getúlio Vargas'],
            ['cidade' => 'Uberlândia', 'estado' => 'MG', 'cep' => '38400-100', 'bairro' => 'Martins', 'rua' => 'Avenida Afonso Pena'],
            ['cidade' => 'Vitória', 'estado' => 'ES', 'cep' => '29010-000', 'bairro' => 'Centro', 'rua' => 'Avenida Jerônimo Monteiro'],
            ['cidade' => 'Curitiba', 'estado' => 'PR', 'cep' => '80010-000', 'bairro' => 'Batel', 'rua' => 'Avenida do Batel'],
            ['cidade' => 'Londrina', 'estado' => 'PR', 'cep' => '86010-000', 'bairro' => 'Centro', 'rua' => 'Rua Sergipe'],
            ['cidade' => 'Porto Alegre', 'estado' => 'RS', 'cep' => '90010-000', 'bairro' => 'Moinhos de Vento', 'rua' => 'Rua Padre Chagas'],
            ['cidade' => 'Caxias do Sul', 'estado' => 'RS', 'cep' => '95020-000', 'bairro' => 'Pio X', 'rua' => 'Rua Sinimbu'],
            ['cidade' => 'Florianópolis', 'estado' => 'SC', 'cep' => '88010-000', 'bairro' => 'Centro', 'rua' => 'Rua Felipe Schmidt'],
            ['cidade' => 'Joinville', 'estado' => 'SC', 'cep' => '89201-000', 'bairro' => 'América', 'rua' => 'Rua Blumenau'],
            ['cidade' => 'Salvador', 'estado' => 'BA', 'cep' => '40020-000', 'bairro' => 'Pelourinho', 'rua' => 'Largo do Pelourinho'],
            ['cidade' => 'Recife', 'estado' => 'PE', 'cep' => '50030-000', 'bairro' => 'Boa Viagem', 'rua' => 'Avenida Boa Viagem'],
            ['cidade' => 'Fortaleza', 'estado' => 'CE', 'cep' => '60060-000', 'bairro' => 'Aldeota', 'rua' => 'Avenida Dom Luís'],
            ['cidade' => 'Natal', 'estado' => 'RN', 'cep' => '59020-000', 'bairro' => 'Tirol', 'rua' => 'Avenida Hermes da Fonseca'],
            ['cidade' => 'João Pessoa', 'estado' => 'PB', 'cep' => '58010-000', 'bairro' => 'Tambaú', 'rua' => 'Avenida Olinda'],
            ['cidade' => 'Maceió', 'estado' => 'AL', 'cep' => '57020-000', 'bairro' => 'Ponta Verde', 'rua' => 'Rua Engenheiro Mário de Gusmão'],
            ['cidade' => 'Brasília', 'estado' => 'DF', 'cep' => '70040-000', 'bairro' => 'Asa Sul', 'rua' => 'CLS 204 Bloco B'],
            ['cidade' => 'Goiânia', 'estado' => 'GO', 'cep' => '74010-000', 'bairro' => 'Setor Bueno', 'rua' => 'Avenida T-4'],
            ['cidade' => 'Cuiabá', 'estado' => 'MT', 'cep' => '78005-000', 'bairro' => 'Bosque da Saúde', 'rua' => 'Avenida CPA'],
            ['cidade' => 'Campo Grande', 'estado' => 'MS', 'cep' => '79002-000', 'bairro' => 'Chácara Cachoeira', 'rua' => 'Rua Ceará'],
            ['cidade' => 'Manaus', 'estado' => 'AM', 'cep' => '69010-000', 'bairro' => 'Adrianópolis', 'rua' => 'Avenida Maceió'],
            ['cidade' => 'Belém', 'estado' => 'PA', 'cep' => '66010-000', 'bairro' => 'Nazaré', 'rua' => 'Avenida Nazaré'],
        ];

        // Combinações de nomes realistas
        $prefixos = [
            'Instituto', 'Associação', 'Fundação', 'Coletivo', 'Rede', 'Projeto',
            'Movimento', 'Centro Cultural', 'Espaço Literário', 'Ação', 'Aliança', 'Grupo'
        ];

        $substantivos = [
            'Leitura Viva', 'Livro Aberto', 'Saber Comunitário', 'Letras da Cidadania',
            'ReciclaLivros', 'Saber Compartilhado', 'Educação & Arte', 'Páginas da Esperança',
            'Raízes Literárias', 'Vozes do Conhecimento', 'Horizontes do Saber', 'Terra das Letras',
            'Luz do Saber', 'Passo Solidário', 'Leitores do Amanhã', 'Cultivar Conhecimento',
            'Livro no Ponto', 'Mundo da Leitura', 'Semente da Sabedoria', 'EcoLeitura',
            'Aprender & Preservar', 'Biblioteca Viva', 'Lendo com o Futuro', 'Palavras da Terra',
            'Juventude & Leitura', 'Saber Sem Barreiras', 'Novo Olhar Literário', 'Geração Leitora'
        ];

        $sufixos = [
            'do Brasil', 'Brasil Solidário', 'Comunitário', 'Regional', 'Sustentável',
            'Social', 'Popular', 'Ecologia & Letras', 'Pela Educação', 'Sem Fronteiras',
            'Integrado', 'da Amazônia', 'do Cerrado', 'Litorâneo', 'Paulistano', ''
        ];

        $justificativasNome = [
            'Alteração estatutária aprovada em assembleia geral de membros.',
            'Adequação da razão social ao novo escopo pedagógico da instituição.',
            'Unificação de identidade com a rede nacional de bibliotecas comunitárias.',
            'Atualização de denominação após fusão com projeto cultural regional.',
            'Nova identidade visual e denominação social registrada em cartório.',
        ];

        $justificativasEndereco = [
            'Mudança para sede própria com maior capacidade de armazenamento de livros.',
            'Nova localização com acessibilidade plena e proximidade de transporte público.',
            'Expansão das salas de leitura e oficina para novo endereço na região central.',
            'Transferência das atividades administrativas para o novo polo comunitário.',
            'Novo galpão logístico para triagem e higienização dos volumes arrecadados.',
        ];

        $motivosRecusa = [
            'Comprovante de endereço anexado está em nome de terceiro sem contrato de locação.',
            'CNPJ informado no comprovante não confere com o novo endereço pretendido.',
            'Nome proposto possui similaridade excessiva com outra entidade já cadastrada na região.',
            'Ata de assembleia estatutária não possui registro em cartório competente.',
            'Documentação ilegível. Favor reenviar cópia autenticada do estatuto atualizado.',
        ];

        $ongsCriadas = Ong::all()->all();
        $totalAtual = count($ongsCriadas);
        $totalDesejado = 150;
        $precisaCriar = max(0, $totalDesejado - $totalAtual);

        $this->command->info("Banco possui {$totalAtual} ONGs. Criando {$precisaCriar} novas para complementar...");

        for ($i = 1; $i <= $precisaCriar; $i++) {
            $prefixo = $prefixos[array_rand($prefixos)];
            $substantivo = $substantivos[array_rand($substantivos)];
            $sufixo = $sufixos[array_rand($sufixos)];

            $nomeOng = trim("{$prefixo} {$substantivo} {$sufixo}");
            $nomeOngFinal = $nomeOng . " " . rand(100, 9999);

            $emailLogin = "ong." . Str::random(8) . "@ecopoint.org";

            // Gera CNPJ formatado 00.000.000/0001-00
            $p1 = str_pad((string) rand(10, 99), 2, '0', STR_PAD_LEFT);
            $p2 = str_pad((string) rand(100, 999), 3, '0', STR_PAD_LEFT);
            $p3 = str_pad((string) rand(100, 999), 3, '0', STR_PAD_LEFT);
            $dv = str_pad((string) rand(10, 99), 2, '0', STR_PAD_LEFT);
            $cnpj = "{$p1}.{$p2}.{$p3}/0001-{$dv}";

            $cidadeInfo = $cidades[array_rand($cidades)];
            $numero = (string) rand(10, 3500);
            $telefoneDdd = rand(11, 99);
            $telefoneNum = rand(98000, 99999) . '-' . rand(1000, 9999);
            $telefone = "({$telefoneDdd}) {$telefoneNum}";

            // Data de criação distribuída ao longo dos últimos 10 meses
            $mes = rand(1, 11);
            $dia = rand(1, 28);
            $createdAt = Carbon::create(2026, $mes, $dia, rand(8, 18), rand(0, 59));

            // Cria Usuário da ONG
            $usuario = User::create([
                'name' => $nomeOngFinal,
                'email' => $emailLogin,
                'password' => $defaultPassword,
                'role' => 'ong',
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            // Cria ONG
            $ong = Ong::create([
                'user_id' => $usuario->id,
                'nome' => $nomeOngFinal,
                'cnpj' => $cnpj,
                'telefone' => $telefone,
                'email_contato' => "contato.{$slug}@gmail.com",
                'descricao' => "Instituição atuante na área de arrecadação de acervo didático, doação de livros infantojuvenis e fomento à cultura leitora em comunidades.",
                'cep' => $cidadeInfo['cep'],
                'endereco' => $cidadeInfo['rua'],
                'numero' => $numero,
                'complemento' => rand(0, 1) ? 'Sala ' . rand(10, 50) : null,
                'bairro' => $cidadeInfo['bairro'],
                'cidade' => $cidadeInfo['cidade'],
                'estado' => $cidadeInfo['estado'],
                'ativo' => rand(1, 10) > 1, // ~90% ativas, ~10% inativas
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            $ongsCriadas[] = $ong;

            // Criar 1 a 2 pontos de coleta para ~60% das ONGs
            if ($ong->ativo && rand(1, 10) <= 6 && $materiais->isNotEmpty()) {
                $pontoNome = "Ponto de Coleta {$ong->cidade} - " . Str::limit($ong->nome, 30);
                $ponto = PontoDeColeta::create([
                    'ong_id' => $ong->id,
                    'nome' => $pontoNome,
                    'descricao' => 'Ponto de arrecadação de livros para projetos sociais e bibliotecas comunitárias parceiras.',
                    'cep' => $ong->cep,
                    'endereco' => $ong->endereco,
                    'numero' => $ong->numero,
                    'complemento' => $ong->complemento,
                    'bairro' => $ong->bairro,
                    'cidade' => $ong->cidade,
                    'estado' => $ong->estado,
                    'latitude' => -23.550520 + (rand(-500, 500) / 10000),
                    'longitude' => -46.633308 + (rand(-500, 500) / 10000),
                    'horario_funcionamento' => 'Segunda a Sexta, das 09h às 18h',
                    'telefone_contato' => $ong->telefone,
                    'ativo' => true,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                // Vincula materiais
                $ponto->materiaisAceitos()->sync($materiais->random(min(3, $materiais->count()))->pluck('id'));
            }
        }

        $this->command->info("150 ONGs criadas com sucesso!");
        $this->command->info("Agora gerando solicitações de alteração (Pendentes, Aprovadas e Recusadas)...");

        // Embaralha ONGs para distribuir solicitações
        shuffle($ongsCriadas);

        // 1. Gera 30 solicitações PENDENTES (para o administrador analisar e testar aprovar/recusar na prática!)
        $ongsPendentes = array_slice($ongsCriadas, 0, 30);
        foreach ($ongsPendentes as $idx => $ong) {
            $tipo = ($idx % 2 === 0) ? 'nome' : 'endereco';
            $dataEnvio = Carbon::now()->subDays(rand(1, 15))->subHours(rand(1, 12));

            if ($tipo === 'nome') {
                $novoNome = "Nova denominação de " . Str::limit($ong->nome, 35) . " Cultural";
                SolicitacaoAlteracaoOng::create([
                    'ong_id' => $ong->id,
                    'tipo' => 'nome',
                    'dados_atuais' => ['nome' => $ong->nome],
                    'dados_propostos' => ['nome' => $novoNome],
                    'justificativa' => $justificativasNome[array_rand($justificativasNome)],
                    'status' => 'pendente',
                    'created_at' => $dataEnvio,
                    'updated_at' => $dataEnvio,
                ]);
            } else {
                $cidadeNova = $cidades[array_rand($cidades)];
                SolicitacaoAlteracaoOng::create([
                    'ong_id' => $ong->id,
                    'tipo' => 'endereco',
                    'dados_atuais' => [
                        'cep' => $ong->cep,
                        'endereco' => $ong->endereco,
                        'numero' => $ong->numero,
                        'complemento' => $ong->complemento,
                        'bairro' => $ong->bairro,
                        'cidade' => $ong->cidade,
                        'estado' => $ong->estado,
                    ],
                    'dados_propostos' => [
                        'cep' => $cidadeNova['cep'],
                        'endereco' => $cidadeNova['rua'],
                        'numero' => (string) rand(100, 2500),
                        'complemento' => 'Bloco C - Nova Sede',
                        'bairro' => $cidadeNova['bairro'],
                        'cidade' => $cidadeNova['cidade'],
                        'estado' => $cidadeNova['estado'],
                    ],
                    'justificativa' => $justificativasEndereco[array_rand($justificativasEndereco)],
                    'status' => 'pendente',
                    'created_at' => $dataEnvio,
                    'updated_at' => $dataEnvio,
                ]);
            }
        }

        // 2. Gera 25 solicitações APROVADAS
        $ongsAprovadas = array_slice($ongsCriadas, 30, 25);
        foreach ($ongsAprovadas as $idx => $ong) {
            $tipo = ($idx % 2 === 0) ? 'nome' : 'endereco';
            $dataEnvio = Carbon::now()->subDays(rand(20, 60));
            $dataAnalise = (clone $dataEnvio)->addDays(rand(1, 3));

            if ($tipo === 'nome') {
                $nomeAnterior = "Denominação Anterior - " . Str::limit($ong->nome, 30);
                SolicitacaoAlteracaoOng::create([
                    'ong_id' => $ong->id,
                    'user_id' => $admin?->id,
                    'tipo' => 'nome',
                    'dados_atuais' => ['nome' => $nomeAnterior],
                    'dados_propostos' => ['nome' => $ong->nome],
                    'justificativa' => $justificativasNome[array_rand($justificativasNome)],
                    'status' => 'aprovada',
                    'analisado_em' => $dataAnalise,
                    'created_at' => $dataEnvio,
                    'updated_at' => $dataAnalise,
                ]);
            } else {
                $cidadeAntiga = $cidades[array_rand($cidades)];
                SolicitacaoAlteracaoOng::create([
                    'ong_id' => $ong->id,
                    'user_id' => $admin?->id,
                    'tipo' => 'endereco',
                    'dados_atuais' => [
                        'cep' => $cidadeAntiga['cep'],
                        'endereco' => $cidadeAntiga['rua'],
                        'numero' => '100',
                        'complemento' => null,
                        'bairro' => $cidadeAntiga['bairro'],
                        'cidade' => $cidadeAntiga['cidade'],
                        'estado' => $cidadeAntiga['estado'],
                    ],
                    'dados_propostos' => [
                        'cep' => $ong->cep,
                        'endereco' => $ong->endereco,
                        'numero' => $ong->numero,
                        'complemento' => $ong->complemento,
                        'bairro' => $ong->bairro,
                        'cidade' => $ong->cidade,
                        'estado' => $ong->estado,
                    ],
                    'justificativa' => $justificativasEndereco[array_rand($justificativasEndereco)],
                    'status' => 'aprovada',
                    'analisado_em' => $dataAnalise,
                    'created_at' => $dataEnvio,
                    'updated_at' => $dataAnalise,
                ]);
            }
        }

        // 3. Gera 20 solicitações RECUSADAS com motivo
        $ongsRecusadas = array_slice($ongsCriadas, 55, 20);
        foreach ($ongsRecusadas as $idx => $ong) {
            $tipo = ($idx % 2 === 0) ? 'nome' : 'endereco';
            $dataEnvio = Carbon::now()->subDays(rand(10, 45));
            $dataAnalise = (clone $dataEnvio)->addDays(rand(1, 2));

            if ($tipo === 'nome') {
                $nomeInvalido = "Razão Não Aprovada " . rand(100, 999);
                SolicitacaoAlteracaoOng::create([
                    'ong_id' => $ong->id,
                    'user_id' => $admin?->id,
                    'tipo' => 'nome',
                    'dados_atuais' => ['nome' => $ong->nome],
                    'dados_propostos' => ['nome' => $nomeInvalido],
                    'justificativa' => 'Tentativa de alteração com nome abreviado.',
                    'status' => 'recusada',
                    'motivo_recusa' => $motivosRecusa[array_rand($motivosRecusa)],
                    'analisado_em' => $dataAnalise,
                    'created_at' => $dataEnvio,
                    'updated_at' => $dataAnalise,
                ]);
            } else {
                SolicitacaoAlteracaoOng::create([
                    'ong_id' => $ong->id,
                    'user_id' => $admin?->id,
                    'tipo' => 'endereco',
                    'dados_atuais' => [
                        'cep' => $ong->cep,
                        'endereco' => $ong->endereco,
                        'numero' => $ong->numero,
                        'complemento' => $ong->complemento,
                        'bairro' => $ong->bairro,
                        'cidade' => $ong->cidade,
                        'estado' => $ong->estado,
                    ],
                    'dados_propostos' => [
                        'cep' => '99999-999',
                        'endereco' => 'Rua Inexistente',
                        'numero' => '0',
                        'complemento' => 'Sem comprovante',
                        'bairro' => 'Centro',
                        'cidade' => $ong->cidade,
                        'estado' => $ong->estado,
                    ],
                    'justificativa' => 'Mudança informal de depósito de livros.',
                    'status' => 'recusada',
                    'motivo_recusa' => $motivosRecusa[array_rand($motivosRecusa)],
                    'analisado_em' => $dataAnalise,
                    'created_at' => $dataEnvio,
                    'updated_at' => $dataAnalise,
                ]);
            }
        }

        $this->command->info("Carga massiva concluída com sucesso!");
        $this->command->info("Total ONGs: " . Ong::count());
        $this->command->info("Total Solicitações: " . SolicitacaoAlteracaoOng::count() . " (Pendentes: 30, Aprovadas: 25, Recusadas: 20)");
    }
}
