<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\OngSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa se a tela de login pode ser renderizada com sucesso.
     */
    public function test_tela_de_login_pode_ser_renderizada(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertSee('Entrar no EcoPoint');
        $response->assertSee('admin@ecopoint.com');
        $response->assertSee('ong@ecopoint.com');
    }

    /**
     * Testa se o administrador cadastrado via seeder consegue logar e ser redirecionado para o painel admin.
     */
    public function test_administrador_pode_autenticar_com_credenciais_do_seeder_e_ir_para_painel_admin(): void
    {
        $this->seed(AdminUserSeeder::class);

        $response = $this->post(route('login.attempt'), [
            'email' => 'admin@ecopoint.com',
            'password' => 'admin123',
            'perfil' => 'admin',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('admin.dashboard'));

        $followResponse = $this->get(route('admin.dashboard'));
        $followResponse->assertStatus(200);
        $followResponse->assertSee('Painel de Controle do Administrador');
        $followResponse->assertSee('Administrador EcoPoint');
    }

    /**
     * Testa se a ONG cadastrada via seeder consegue logar e ser redirecionada para o painel da ONG.
     */
    public function test_ong_pode_autenticar_com_credenciais_do_seeder_e_ir_para_painel_ong(): void
    {
        $this->seed(OngSeeder::class);

        $response = $this->post(route('login.attempt'), [
            'email' => 'ong@ecopoint.com',
            'password' => 'ong123',
            'perfil' => 'ong',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('ong.dashboard'));

        $followResponse = $this->get(route('ong.dashboard'));
        $followResponse->assertStatus(200);
        $followResponse->assertSee('Painel da Instituição');
        $followResponse->assertSee('ONG Esperança Viva');
    }

    /**
     * Testa se o login é bloqueado quando o perfil selecionado não bate com a role da conta.
     */
    public function test_login_bloqueado_quando_perfil_selecionado_diverge_da_conta(): void
    {
        $this->seed(AdminUserSeeder::class);

        // Usuário admin tentando logar selecionando o perfil "ong"
        $response = $this->from(route('login'))->post(route('login.attempt'), [
            'email' => 'admin@ecopoint.com',
            'password' => 'admin123',
            'perfil' => 'ong',
        ]);

        $this->assertGuest();
        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('perfil');
    }

    /**
     * Testa se visitante sem login é redirecionado ao tentar acessar o painel admin.
     */
    public function test_usuario_nao_autenticado_e_redirecionado_para_login_ao_acessar_painel_admin(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('login'));
    }

    /**
     * Testa se usuário ONG é bloqueado (403) ao tentar acessar área restrita de administrador.
     */
    public function test_usuario_ong_e_bloqueado_ao_tentar_acessar_painel_admin(): void
    {
        $ongUser = User::factory()->create([
            'role' => 'ong',
        ]);

        $response = $this->actingAs($ongUser)->get(route('admin.dashboard'));

        $response->assertStatus(403);
    }

    /**
     * Testa falha de autenticação com senha inválida.
     */
    public function test_usuario_nao_autentica_com_senha_incorreta(): void
    {
        $this->seed(AdminUserSeeder::class);

        $response = $this->from(route('login'))->post(route('login.attempt'), [
            'email' => 'admin@ecopoint.com',
            'password' => 'senha_errada',
        ]);

        $this->assertGuest();
        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('email');
    }

    /**
     * Testa logout com encerramento de sessão.
     */
    public function test_usuario_autenticado_pode_fazer_logout(): void
    {
        $this->seed(AdminUserSeeder::class);
        $admin = User::where('email', 'admin@ecopoint.com')->first();

        $response = $this->actingAs($admin)->post(route('logout'));

        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }
}
