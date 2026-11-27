<?php

namespace Tests\Feature;

use App\Models\Ong;
use App\Models\SolicitacaoAlteracaoOng;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SolicitacaoAlteracaoOngTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $usuarioOng;
    private Ong $ong;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(AdminUserSeeder::class);
        $this->admin = User::where('email', 'admin@ecopoint.com')->first();

        $this->usuarioOng = User::create([
            'name' => 'Instituto Leitura Viva',
            'email' => 'contato@leituraviva.org',
            'password' => Hash::make('senha123456'),
            'role' => 'ong',
        ]);

        $this->ong = Ong::create([
            'user_id' => $this->usuarioOng->id,
            'nome' => 'Instituto Leitura Viva',
            'cnpj' => '12.345.678/0001-90',
            'telefone' => '(11) 98888-7777',
            'email_contato' => 'contato@leituraviva.org',
            'descricao' => 'Incentivo à leitura e doação de livros.',
            'cep' => '01310-100',
            'endereco' => 'Avenida Paulista',
            'numero' => '1000',
            'bairro' => 'Bela Vista',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'ativo' => true,
        ]);
    }

    /**
     * ONG pode atualizar diretamente suas informações de contato e login sem passar por aprovação.
     */
    public function test_ong_pode_atualizar_informacoes_diretas_sem_aprovacao(): void
    {
        $response = $this->actingAs($this->usuarioOng)->put(route('ong.perfil.update'), [
            'email' => 'novologin@leituraviva.org',
            'telefone' => '(11) 99999-0000',
            'email_contato' => 'atendimento@leituraviva.org',
            'descricao' => 'Nova descrição atualizada diretamente.',
        ]);

        $response->assertRedirect(route('ong.perfil.edit'));
        $response->assertSessionHas('sucesso');

        $this->assertDatabaseHas('users', [
            'id' => $this->usuarioOng->id,
            'email' => 'novologin@leituraviva.org',
        ]);

        $this->assertDatabaseHas('ongs', [
            'id' => $this->ong->id,
            'telefone' => '(11) 99999-0000',
            'email_contato' => 'atendimento@leituraviva.org',
            'descricao' => 'Nova descrição atualizada diretamente.',
            'nome' => 'Instituto Leitura Viva',
        ]);
    }

    /**
     * ONG não altera nome ou endereço diretamente pelo update de perfil.
     */
    public function test_ong_nao_altera_nome_diretamente_pelo_perfil_update(): void
    {
        $response = $this->actingAs($this->usuarioOng)->put(route('ong.perfil.update'), [
            'email' => $this->usuarioOng->email,
            'nome' => 'Tentativa de Mudar Nome Direto',
            'telefone' => '(11) 98888-7777',
        ]);

        $response->assertRedirect(route('ong.perfil.edit'));

        $this->assertDatabaseHas('ongs', [
            'id' => $this->ong->id,
            'nome' => 'Instituto Leitura Viva',
        ]);
    }

    /**
     * ONG pode solicitar alteração de nome e gera solicitação pendente sem alterar o cadastro oficial.
     */
    public function test_ong_pode_solicitar_alteracao_de_nome(): void
    {
        $response = $this->actingAs($this->usuarioOng)->post(route('ong.perfil.solicitar'), [
            'tipo' => 'nome',
            'novo_nome' => 'Instituto Leitura e Cultura Viva',
            'justificativa' => 'Atualização estatutária aprovada em assembleia.',
        ]);

        $response->assertRedirect(route('ong.perfil.edit'));
        $response->assertSessionHas('sucesso');

        $this->assertDatabaseHas('solicitacoes_alteracao_ong', [
            'ong_id' => $this->ong->id,
            'tipo' => 'nome',
            'status' => 'pendente',
            'justificativa' => 'Atualização estatutária aprovada em assembleia.',
        ]);

        $this->assertDatabaseHas('ongs', [
            'id' => $this->ong->id,
            'nome' => 'Instituto Leitura Viva',
        ]);
    }

    /**
     * ONG pode solicitar alteração de endereço e gera solicitação pendente.
     */
    public function test_ong_pode_solicitar_alteracao_de_endereco(): void
    {
        $response = $this->actingAs($this->usuarioOng)->post(route('ong.perfil.solicitar'), [
            'tipo' => 'endereco',
            'cep' => '04538-133',
            'endereco' => 'Avenida Brigadeiro Faria Lima',
            'numero' => '2000',
            'complemento' => 'Andar 5',
            'bairro' => 'Itaim Bibi',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'justificativa' => 'Mudança para nova sede administrativa.',
        ]);

        $response->assertRedirect(route('ong.perfil.edit'));
        $response->assertSessionHas('sucesso');

        $this->assertDatabaseHas('solicitacoes_alteracao_ong', [
            'ong_id' => $this->ong->id,
            'tipo' => 'endereco',
            'status' => 'pendente',
        ]);

        $this->assertDatabaseHas('ongs', [
            'id' => $this->ong->id,
            'endereco' => 'Avenida Paulista',
        ]);
    }

    /**
     * ONG não pode abrir solicitação duplicada se já houver uma pendente para o mesmo campo.
     */
    public function test_ong_nao_pode_duplicar_solicitacao_pendente_do_mesmo_tipo(): void
    {
        SolicitacaoAlteracaoOng::create([
            'ong_id' => $this->ong->id,
            'tipo' => 'nome',
            'dados_atuais' => ['nome' => $this->ong->nome],
            'dados_propostos' => ['nome' => 'Novo Nome 1'],
            'status' => 'pendente',
        ]);

        $response = $this->actingAs($this->usuarioOng)->post(route('ong.perfil.solicitar'), [
            'tipo' => 'nome',
            'novo_nome' => 'Novo Nome 2',
        ]);

        $response->assertRedirect(route('ong.perfil.edit'));
        $response->assertSessionHas('error');

        $this->assertEquals(1, SolicitacaoAlteracaoOng::where('ong_id', $this->ong->id)->where('tipo', 'nome')->count());
    }

    /**
     * Administrador pode visualizar listagem de solicitações.
     */
    public function test_administrador_pode_visualizar_solicitacoes(): void
    {
        SolicitacaoAlteracaoOng::create([
            'ong_id' => $this->ong->id,
            'tipo' => 'nome',
            'dados_atuais' => ['nome' => $this->ong->nome],
            'dados_propostos' => ['nome' => 'Instituto Renascer'],
            'status' => 'pendente',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.solicitacoes.index'));

        $response->assertStatus(200);
        $response->assertSee('Solicitações de Alteração');
        $response->assertSee('Instituto Leitura Viva');
        $response->assertSee('Instituto Renascer');
    }

    /**
     * Administrador pode aprovar solicitação, atualizando os dados oficiais da ONG.
     */
    public function test_administrador_pode_aprovar_solicitacao_e_atualizar_dados(): void
    {
        $solicitacao = SolicitacaoAlteracaoOng::create([
            'ong_id' => $this->ong->id,
            'tipo' => 'nome',
            'dados_atuais' => ['nome' => $this->ong->nome],
            'dados_propostos' => ['nome' => 'Instituto Saber Sem Limites'],
            'status' => 'pendente',
        ]);

        $response = $this->actingAs($this->admin)->patch(route('admin.solicitacoes.aprovar', $solicitacao));

        $response->assertRedirect();
        $response->assertSessionHas('sucesso');

        $this->assertDatabaseHas('solicitacoes_alteracao_ong', [
            'id' => $solicitacao->id,
            'status' => 'aprovada',
            'user_id' => $this->admin->id,
        ]);

        $this->assertDatabaseHas('ongs', [
            'id' => $this->ong->id,
            'nome' => 'Instituto Saber Sem Limites',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $this->usuarioOng->id,
            'name' => 'Instituto Saber Sem Limites',
        ]);
    }

    /**
     * Administrador pode recusar solicitação informando motivo, mantendo dados originais da ONG.
     */
    public function test_administrador_pode_recusar_solicitacao_com_motivo(): void
    {
        $solicitacao = SolicitacaoAlteracaoOng::create([
            'ong_id' => $this->ong->id,
            'tipo' => 'endereco',
            'dados_atuais' => ['endereco' => 'Avenida Paulista'],
            'dados_propostos' => [
                'cep' => '04538-133',
                'endereco' => 'Rua Inexistente',
                'numero' => '10',
                'bairro' => 'Bairro',
                'cidade' => 'Cidade',
                'estado' => 'SP',
            ],
            'status' => 'pendente',
        ]);

        $response = $this->actingAs($this->admin)->patch(route('admin.solicitacoes.recusar', $solicitacao), [
            'motivo_recusa' => 'Comprovante de endereço anexado não confere.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('sucesso');

        $this->assertDatabaseHas('solicitacoes_alteracao_ong', [
            'id' => $solicitacao->id,
            'status' => 'recusada',
            'motivo_recusa' => 'Comprovante de endereço anexado não confere.',
            'user_id' => $this->admin->id,
        ]);

        $this->assertDatabaseHas('ongs', [
            'id' => $this->ong->id,
            'endereco' => 'Avenida Paulista',
        ]);
    }

    /**
     * Usuário ONG não pode acessar ou aprovar solicitações administrativas.
     */
    public function test_ong_nao_pode_acessar_ou_aprovar_solicitacoes(): void
    {
        $solicitacao = SolicitacaoAlteracaoOng::create([
            'ong_id' => $this->ong->id,
            'tipo' => 'nome',
            'dados_atuais' => ['nome' => $this->ong->nome],
            'dados_propostos' => ['nome' => 'Instituto Invasor'],
            'status' => 'pendente',
        ]);

        $response = $this->actingAs($this->usuarioOng)->get(route('admin.solicitacoes.index'));
        $response->assertStatus(403);

        $responseAprovar = $this->actingAs($this->usuarioOng)->patch(route('admin.solicitacoes.aprovar', $solicitacao));
        $responseAprovar->assertStatus(403);
    }
}
