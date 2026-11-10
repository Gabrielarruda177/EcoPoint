<?php

namespace Tests\Feature;

use App\Models\MaterialAceito;
use App\Models\Ong;
use App\Models\PontoDeColeta;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\MaterialAceitoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class OngPontoDeColetaTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Cria um usuário do tipo ONG acompanhado do seu registro de Ong institucional.
     */
    protected function criarUsuarioEOng(string $nome = 'ONG Saber Vivo', string $email = 'ong@sabervivo.org'): array
    {
        $usuario = User::factory()->create([
            'name' => $nome,
            'email' => $email,
            'password' => Hash::make('senha12345'),
            'role' => 'ong',
        ]);

        $ong = Ong::create([
            'user_id' => $usuario->id,
            'nome' => $nome,
            'cnpj' => '12.345.678/0001-99',
            'telefone' => '(11) 98765-4321',
            'email_contato' => 'contato@sabervivo.org',
            'descricao' => 'Instituição parceira de arrecadação de livros acadêmicos.',
            'ativo' => true,
        ]);

        return [$usuario, $ong];
    }

    /**
     * Testa se a ONG autenticada consegue acessar seu painel de controle.
     */
    public function test_ong_autenticada_pode_acessar_sua_dashboard(): void
    {
        [$usuario, $ong] = $this->criarUsuarioEOng();

        $response = $this->actingAs($usuario)->get(route('ong.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Painel da Instituição');
        $response->assertSee($ong->nome);
        $response->assertSee('Meus Pontos de Coleta');
    }

    /**
     * Testa se o visitante não logado é redirecionado ao tentar acessar o painel da ONG.
     */
    public function test_visitante_nao_autenticado_e_redirecionado_ao_tentar_acessar_ong(): void
    {
        $response = $this->get(route('ong.dashboard'));

        $response->assertRedirect(route('login'));
    }

    /**
     * Testa se um administrador é barrado ao tentar acessar o painel exclusivo da ONG.
     */
    public function test_administrador_nao_pode_acessar_painel_da_ong(): void
    {
        $this->seed(AdminUserSeeder::class);
        $admin = User::where('email', 'admin@ecopoint.com')->first();

        $response = $this->actingAs($admin)->get(route('ong.dashboard'));

        $response->assertStatus(403);
    }

    /**
     * Testa se a ONG consegue visualizar a lista de pontos que pertencem a ela.
     */
    public function test_ong_pode_visualizar_listagem_de_seus_pontos_de_coleta(): void
    {
        [$usuario, $ong] = $this->criarUsuarioEOng();

        $ponto = PontoDeColeta::create([
            'ong_id' => $ong->id,
            'nome' => 'Ponto Biblioteca Central',
            'endereco' => 'Rua das Flores',
            'numero' => '123',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'ativo' => true,
        ]);

        $response = $this->actingAs($usuario)->get(route('ong.pontos.index'));

        $response->assertStatus(200);
        $response->assertSee('Ponto Biblioteca Central');
        $response->assertSee('Rua das Flores, 123');
    }

    /**
     * Testa se a ONG não enxerga pontos cadastrados por outras ONGs em sua listagem.
     */
    public function test_ong_nao_enxerga_pontos_de_outras_ongs_na_sua_listagem(): void
    {
        [$usuarioA, $ongA] = $this->criarUsuarioEOng('ONG A', 'onga@email.com');
        [$usuarioB, $ongB] = $this->criarUsuarioEOng('ONG B', 'ongb@email.com');

        $pontoA = PontoDeColeta::create([
            'ong_id' => $ongA->id,
            'nome' => 'Ponto Exclusivo ONG A',
            'endereco' => 'Rua Alpha',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'ativo' => true,
        ]);

        $pontoB = PontoDeColeta::create([
            'ong_id' => $ongB->id,
            'nome' => 'Ponto Exclusivo ONG B',
            'endereco' => 'Rua Beta',
            'cidade' => 'Campinas',
            'estado' => 'SP',
            'ativo' => true,
        ]);

        $response = $this->actingAs($usuarioA)->get(route('ong.pontos.index'));

        $response->assertStatus(200);
        $response->assertSee('Ponto Exclusivo ONG A');
        $response->assertDontSee('Ponto Exclusivo ONG B');
    }

    /**
     * Testa se a tela de criação carrega com os materiais aceitos disponíveis.
     */
    public function test_tela_de_cadastro_de_ponto_carrega_materiais_aceitos(): void
    {
        $this->seed(MaterialAceitoSeeder::class);
        [$usuario] = $this->criarUsuarioEOng();

        $response = $this->actingAs($usuario)->get(route('ong.pontos.create'));

        $response->assertStatus(200);
        $response->assertSee('Cadastrar Novo Ponto de Coleta');
        $response->assertSee('Livros Didáticos');
        $response->assertSee('Apostilas Pré-Vestibular / ENEM');
    }

    /**
     * Testa se a ONG consegue cadastrar um novo ponto vinculado a ela com materiais aceitos.
     */
    public function test_ong_pode_cadastrar_novo_ponto_de_coleta_com_materiais(): void
    {
        $this->seed(MaterialAceitoSeeder::class);
        [$usuario, $ong] = $this->criarUsuarioEOng();
        $materiais = MaterialAceito::take(2)->pluck('id')->toArray();

        $dadosPonto = [
            'nome' => 'Ponto Sede Social',
            'cep' => '01310-200',
            'endereco' => 'Avenida Paulista',
            'numero' => '2000',
            'complemento' => 'Andar 5',
            'bairro' => 'Bela Vista',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'telefone_contato' => '(11) 99999-8888',
            'horario_funcionamento' => 'Seg a Sex das 10h às 18h',
            'descricao' => 'Caixa de coleta no saguão.',
            'ativo' => 1,
            'materiais' => $materiais,
        ];

        $response = $this->actingAs($usuario)->post(route('ong.pontos.store'), $dadosPonto);

        $response->assertRedirect(route('ong.pontos.index'));
        $response->assertSessionHas('success', 'Ponto de coleta cadastrado com sucesso!');

        $this->assertDatabaseHas('pontos_de_coleta', [
            'ong_id' => $ong->id,
            'nome' => 'Ponto Sede Social',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'ativo' => 1,
        ]);

        $pontoCriado = PontoDeColeta::where('nome', 'Ponto Sede Social')->first();
        $this->assertNotNull($pontoCriado);
        $this->assertCount(2, $pontoCriado->materiaisAceitos);
    }

    /**
     * Testa se a ONG consegue atualizar seu próprio ponto de coleta.
     */
    public function test_ong_pode_atualizar_seu_proprio_ponto_de_coleta(): void
    {
        $this->seed(MaterialAceitoSeeder::class);
        [$usuario, $ong] = $this->criarUsuarioEOng();

        $ponto = PontoDeColeta::create([
            'ong_id' => $ong->id,
            'nome' => 'Nome Antigo do Ponto',
            'endereco' => 'Rua Velha',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'ativo' => true,
        ]);

        $material = MaterialAceito::first();

        $response = $this->actingAs($usuario)->put(route('ong.pontos.update', $ponto), [
            'nome' => 'Nome Atualizado do Ponto',
            'endereco' => 'Rua Nova',
            'numero' => '500',
            'cidade' => 'Santos',
            'estado' => 'SP',
            'ativo' => 1,
            'materiais' => [$material->id],
        ]);

        $response->assertRedirect(route('ong.pontos.index'));
        $response->assertSessionHas('success', 'Ponto de coleta atualizado com sucesso!');

        $this->assertDatabaseHas('pontos_de_coleta', [
            'id' => $ponto->id,
            'nome' => 'Nome Atualizado do Ponto',
            'cidade' => 'Santos',
        ]);

        $this->assertDatabaseMissing('pontos_de_coleta', [
            'id' => $ponto->id,
            'nome' => 'Nome Antigo do Ponto',
        ]);
    }

    /**
     * Testa se a ONG consegue excluir seu próprio ponto de coleta.
     */
    public function test_ong_pode_excluir_seu_proprio_ponto_de_coleta(): void
    {
        [$usuario, $ong] = $this->criarUsuarioEOng();

        $ponto = PontoDeColeta::create([
            'ong_id' => $ong->id,
            'nome' => 'Ponto Para Excluir',
            'endereco' => 'Rua Descarte',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'ativo' => true,
        ]);

        $response = $this->actingAs($usuario)->delete(route('ong.pontos.destroy', $ponto));

        $response->assertRedirect(route('ong.pontos.index'));
        $response->assertSessionHas('success', 'Ponto de coleta excluído com sucesso!');

        $this->assertDatabaseMissing('pontos_de_coleta', [
            'id' => $ponto->id,
        ]);
    }

    /**
     * Testa a restrição de segurança: ONG B não pode editar ponto de coleta pertencente à ONG A.
     */
    public function test_ong_nao_pode_editar_nem_atualizar_ponto_de_outra_ong(): void
    {
        [$usuarioA, $ongA] = $this->criarUsuarioEOng('ONG A', 'a@email.com');
        [$usuarioB, $ongB] = $this->criarUsuarioEOng('ONG B', 'b@email.com');

        $pontoA = PontoDeColeta::create([
            'ong_id' => $ongA->id,
            'nome' => 'Ponto da ONG A',
            'endereco' => 'Rua A',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'ativo' => true,
        ]);

        // Tentativa de abrir formulário de edição
        $responseGet = $this->actingAs($usuarioB)->get(route('ong.pontos.edit', $pontoA));
        $responseGet->assertStatus(403);

        // Tentativa de atualizar via PUT
        $responsePut = $this->actingAs($usuarioB)->put(route('ong.pontos.update', $pontoA), [
            'nome' => 'Hackeado pela ONG B',
            'endereco' => 'Rua B',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
        ]);
        $responsePut->assertStatus(403);

        $this->assertDatabaseHas('pontos_de_coleta', [
            'id' => $pontoA->id,
            'nome' => 'Ponto da ONG A',
        ]);
    }

    /**
     * Testa a restrição de segurança: ONG B não pode excluir ponto de coleta pertencente à ONG A.
     */
    public function test_ong_nao_pode_excluir_ponto_de_outra_ong(): void
    {
        [$usuarioA, $ongA] = $this->criarUsuarioEOng('ONG A', 'a@email.com');
        [$usuarioB, $ongB] = $this->criarUsuarioEOng('ONG B', 'b@email.com');

        $pontoA = PontoDeColeta::create([
            'ong_id' => $ongA->id,
            'nome' => 'Ponto Protegido da ONG A',
            'endereco' => 'Rua Segura',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'ativo' => true,
        ]);

        $response = $this->actingAs($usuarioB)->delete(route('ong.pontos.destroy', $pontoA));

        $response->assertStatus(403);

        $this->assertDatabaseHas('pontos_de_coleta', [
            'id' => $pontoA->id,
        ]);
    }

    /**
     * Testa se a ONG consegue visualizar e atualizar seu perfil institucional.
     */
    public function test_ong_pode_atualizar_seu_perfil_institucional(): void
    {
        [$usuario, $ong] = $this->criarUsuarioEOng('Nome Original', 'ong@original.org');

        $responseGet = $this->actingAs($usuario)->get(route('ong.perfil.edit'));
        $responseGet->assertStatus(200);
        $responseGet->assertSee('Perfil Institucional da Organização');
        $responseGet->assertSee('Nome Original');

        $responsePut = $this->actingAs($usuario)->put(route('ong.perfil.update'), [
            'nome' => 'Nome da ONG Atualizado',
            'cnpj' => '99.888.777/0001-66',
            'telefone' => '(11) 91111-2222',
            'email_contato' => 'novo@ong.org',
            'descricao' => 'Nova descrição institucional.',
        ]);

        $responsePut->assertRedirect(route('ong.perfil.edit'));
        $responsePut->assertSessionHas('success', 'Perfil da instituição atualizado com sucesso!');

        $this->assertDatabaseHas('ongs', [
            'id' => $ong->id,
            'nome' => 'Nome da ONG Atualizado',
            'cnpj' => '99.888.777/0001-66',
            'telefone' => '(11) 91111-2222',
            'email_contato' => 'novo@ong.org',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $usuario->id,
            'name' => 'Nome da ONG Atualizado',
        ]);
    }
}

