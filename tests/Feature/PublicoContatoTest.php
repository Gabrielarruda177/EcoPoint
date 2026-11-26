<?php

namespace Tests\Feature;

use App\Mail\ContatoRecebidoMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PublicoContatoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa se a página de Fale Conosco pode ser renderizada com sucesso.
     */
    public function test_tela_de_fale_conosco_pode_ser_renderizada(): void
    {
        $response = $this->get(route('publico.contato'));

        $response->assertStatus(200);
        $response->assertSee('Fale com a Equipe EcoPoint');
        $response->assertSee('ecopointssuporte@gmail.com');
        $response->assertSee('Envie sua Mensagem');
        $response->assertSee('name="nome"', false);
        $response->assertSee('name="email"', false);
        $response->assertSee('name="assunto"', false);
        $response->assertSee('name="mensagem"', false);
    }

    /**
     * Testa se o formulário rejeita submissão com campos vazios.
     */
    public function test_formulario_de_contato_valida_campos_obrigatorios(): void
    {
        $response = $this->post(route('publico.contato.enviar'), [
            'nome' => '',
            'email' => '',
            'assunto' => '',
            'mensagem' => '',
        ]);

        $response->assertSessionHasErrors(['nome', 'email', 'assunto', 'mensagem']);
    }

    /**
     * Testa se o formulário valida formato de e-mail e tamanhos mínimos.
     */
    public function test_formulario_de_contato_valida_formato_e_tamanho_minimo(): void
    {
        $response = $this->post(route('publico.contato.enviar'), [
            'nome' => 'A',
            'email' => 'email-invalido',
            'assunto' => 'Oi',
            'mensagem' => 'Curto',
        ]);

        $response->assertSessionHasErrors(['nome', 'email', 'assunto', 'mensagem']);
    }

    /**
     * Testa se o e-mail de contato é enviado com sucesso para a caixa de suporte configurada.
     */
    public function test_mensagem_de_contato_e_enviada_com_sucesso_para_o_suporte(): void
    {
        Mail::fake();

        $dados = [
            'nome' => 'Mariana Oliveira',
            'email' => 'mariana.oliveira@teste.com',
            'assunto' => 'Dúvida sobre doação de livros acadêmicos',
            'mensagem' => 'Olá equipe EcoPoint, gostaria de saber se vocês aceitam livros de cálculo e engenharia em qualquer ponto de coleta.',
        ];

        $response = $this->post(route('publico.contato.enviar'), $dados);

        $response->assertRedirect(route('publico.contato'));
        $response->assertSessionHas('success');

        $emailSuporte = config('mail.support_address');

        Mail::assertSent(ContatoRecebidoMail::class, function (ContatoRecebidoMail $mail) use ($dados, $emailSuporte) {
            return $mail->hasTo($emailSuporte)
                && $mail->nome === $dados['nome']
                && $mail->email === $dados['email']
                && $mail->assunto === $dados['assunto']
                && $mail->mensagem === $dados['mensagem']
                && $mail->hasReplyTo($dados['email'], $dados['nome']);
        });
    }

    /**
     * Testa se a view do Mailable renderiza corretamente as informações enviadas.
     */
    public function test_mailable_renderiza_corretamente(): void
    {
        $mailable = new ContatoRecebidoMail(
            nome: 'Carlos Santos',
            email: 'carlos@teste.com',
            assunto: 'Sugestão de novo ponto',
            mensagem: 'Gostaria de indicar a biblioteca comunitária do meu bairro como ponto de coleta.'
        );

        $mailable->assertSeeInHtml('Carlos Santos');
        $mailable->assertSeeInHtml('carlos@teste.com');
        $mailable->assertSeeInHtml('Sugestão de novo ponto');
        $mailable->assertSeeInHtml('Gostaria de indicar a biblioteca comunitária');
        $mailable->assertSeeInHtml('ecopointssuporte@gmail.com');
    }
}
