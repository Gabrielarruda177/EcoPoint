<?php

namespace Tests\Feature;

use App\Models\Ong;
use App\Models\PontoDeColeta;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminOngTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa se a tela de cadastro de ONG pode ser renderizada com sucesso.
     */
    public function test_tela_de_cadastro_de_ong_pode_ser_renderizada(): void
    {
        $this->seed(AdminUserSeeder::class);
        $admin = User::where('email', 'admin@ecopoint.com')->first();

        $response = $this->actingAs($admin)->get(route('admin.ongs.create'));

        $response->assertStatus(200);
        $response->assertSee('Cadastrar Nova ONG');
        $response->assertSee('Dados da Instituição');
        $response->assertSee('Acesso ao Sistema');
    }

    /**
     * Testa se o administrador consegue cadastrar uma nova ONG e seu usuário de acesso.
     */
    public function test_administrador_pode_cadastrar_nova_ong_e_usuario(): void
    {
        $this->seed(AdminUserSeeder::class);
        $admin = User::where('email', 'admin@ecopoint.com')->first();

        $response = $this->actingAs($admin)->post(route('admin.ongs.store'), [
            'nome' => 'ONG Esperança',
            'email' => 'contato@esperanca.org',
            'cnpj' => '11.222.333/0001-44',
            'telefone' => '(11) 97777-6666',
            'email_contato' => 'atendimento@esperanca.org',
            'descricao' => 'ONG voltada para redistribuição de livros escolares.',
            'senha' => 'senha12345',
            'senha_confirmation' => 'senha12345',
        ]);

        $response->assertRedirect(route('admin.ongs.index'));
        $response->assertSessionHas('success', 'ONG cadastrada com sucesso!');

        $this->assertDatabaseHas('users', [
            'email' => 'contato@esperanca.org',
            'name' => 'ONG Esperança',
            'role' => 'ong',
        ]);

        $this->assertDatabaseHas('ongs', [
            'nome' => 'ONG Esperança',
            'cnpj' => '11.222.333/0001-44',
            'telefone' => '(11) 97777-6666',
            'ativo' => 1,
        ]);
    }

    /**
     * Testa se o administrador consegue atualizar os dados de uma ONG e seu usuário.
     */
    public function test_administrador_pode_atualizar_ong_e_usuario(): void
    {
        $this->seed(AdminUserSeeder::class);
        $admin = User::where('email', 'admin@ecopoint.com')->first();

        $usuarioOng = User::factory()->create([
            'name' => 'Nome Antigo',
            'email' => 'ongantiga@email.com',
            'role' => 'ong',
        ]);

        $ong = Ong::create([
            'user_id' => $usuarioOng->id,
            'nome' => 'ONG Antiga',
            'cnpj' => '12.345.678/0001-90',
            'telefone' => '(11) 99999-9999',
            'email_contato' => 'contato@ongantiga.com',
            'descricao' => 'Descrição antiga',
            'ativo' => true,
        ]);

        $response = $this->actingAs($admin)->put(route('admin.ongs.update', $ong), [
            'nome' => 'ONG Nome Novo',
            'email' => 'ongnova@email.com',
            'cnpj' => '98.765.432/0001-10',
            'telefone' => '(11) 98888-8888',
            'email_contato' => 'contato@ongnova.com',
            'descricao' => 'Nova descrição',
            'senha' => 'novasenha123',
            'senha_confirmation' => 'novasenha123',
        ]);

        $response->assertRedirect(route('admin.ongs.index'));
        $response->assertSessionHas('success', 'ONG atualizada com sucesso!');

        $this->assertDatabaseHas('ongs', [
            'id' => $ong->id,
            'nome' => 'ONG Nome Novo',
            'cnpj' => '98.765.432/0001-10',
            'telefone' => '(11) 98888-8888',
            'email_contato' => 'contato@ongnova.com',
            'descricao' => 'Nova descrição',
        ]);

        $usuarioOng->refresh();
        $this->assertEquals('ONG Nome Novo', $usuarioOng->name);
        $this->assertEquals('ongnova@email.com', $usuarioOng->email);
        $this->assertTrue(Hash::check('novasenha123', $usuarioOng->password));
    }

    /**
     * Testa se o administrador consegue excluir uma ONG, seus pontos e o usuário correspondente.
     */
    public function test_administrador_pode_excluir_ong(): void
    {
        $this->seed(AdminUserSeeder::class);
        $admin = User::where('email', 'admin@ecopoint.com')->first();

        $usuarioOng = User::factory()->create(['role' => 'ong']);
        $ong = Ong::create([
            'user_id' => $usuarioOng->id,
            'nome' => 'ONG Para Deletar',
            'ativo' => true,
        ]);

        PontoDeColeta::create([
            'ong_id' => $ong->id,
            'nome' => 'Ponto Central',
            'cep' => '12345-678',
            'endereco' => 'Rua Exemplo',
            'numero' => '100',
            'bairro' => 'Centro',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'ativo' => true,
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.ongs.destroy', $ong));

        $response->assertRedirect(route('admin.ongs.index'));
        $response->assertSessionHas('success', 'ONG excluída com sucesso!');

        $this->assertDatabaseMissing('ongs', ['id' => $ong->id]);
        $this->assertDatabaseMissing('users', ['id' => $usuarioOng->id]);
        $this->assertDatabaseMissing('pontos_de_coleta', ['ong_id' => $ong->id]);
    }

    /**
     * Testa se o status da ONG pode ser alternado entre ativo e inativo.
     */
    public function test_administrador_pode_alternar_status_da_ong(): void
    {
        $this->seed(AdminUserSeeder::class);
        $admin = User::where('email', 'admin@ecopoint.com')->first();

        $usuarioOng = User::factory()->create(['role' => 'ong']);
        $ong = Ong::create([
            'user_id' => $usuarioOng->id,
            'nome' => 'ONG Status',
            'ativo' => true,
        ]);

        $response = $this->actingAs($admin)->patch(route('admin.ongs.toggleStatus', $ong));

        $response->assertRedirect(route('admin.ongs.index'));
        $response->assertSessionHas('success', 'Status da ONG atualizado!');

        $ong->refresh();
        $this->assertFalse($ong->ativo);

        // Alterna novamente para ativo
        $this->actingAs($admin)->patch(route('admin.ongs.toggleStatus', $ong));
        $ong->refresh();
        $this->assertTrue($ong->ativo);
    }
}
