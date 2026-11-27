<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Mail\ContatoRecebidoMail;
use App\Models\Ong;
use App\Models\PontoDeColeta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Throwable;

class HomeController extends Controller
{
    /**
     * Exibe a página inicial pública do sistema.
     */
    public function index(): View
    {
        $pontos = PontoDeColeta::with(['ong', 'materiaisAceitos'])->get();
        $ongs = Ong::all();

        return view('publico.home', compact('pontos', 'ongs'));
    }

    public function apiPontos()
    {
        $pontos = PontoDeColeta::with(['ong', 'materiaisAceitos'])->get();
        $ongs = Ong::all();

        return response()->json([
            'pontos' => $pontos,
            'ongs' => $ongs
        ]);
    }

    /**
     * Exibe a página institucional Sobre Nós.
     */
    public function sobre(): View
    {
        return view('publico.sobre');
    }

    /**
     * Exibe a página do formulário Fale Conosco.
     */
    public function contato(): View
    {
        return view('publico.contato');
    }

    /**
     * Processa o formulário de contato e dispara o e-mail para o suporte.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function enviarContato(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'min:2', 'max:120'],
            'email' => ['required', 'email', 'max:120'],
            'assunto' => ['required', 'string', 'min:3', 'max:150'],
            'mensagem' => ['required', 'string', 'min:10', 'max:3000'],
        ], [
            'nome.required' => 'Por favor, informe seu nome.',
            'nome.min' => 'O nome deve ter no mínimo 2 caracteres.',
            'nome.max' => 'O nome não pode exceder 120 caracteres.',
            'email.required' => 'Por favor, informe seu e-mail de contato.',
            'email.email' => 'Informe um endereço de e-mail válido.',
            'email.max' => 'O e-mail não pode exceder 120 caracteres.',
            'assunto.required' => 'Por favor, informe o assunto da mensagem.',
            'assunto.min' => 'O assunto deve ter no mínimo 3 caracteres.',
            'assunto.max' => 'O assunto não pode exceder 150 caracteres.',
            'mensagem.required' => 'Por favor, escreva sua mensagem.',
            'mensagem.min' => 'A mensagem deve ter no mínimo 10 caracteres para que possamos compreendê-la.',
            'mensagem.max' => 'A mensagem não pode exceder 3000 caracteres.',
        ]);

        $destinatario = config('mail.support_address', env('MAIL_SUPPORT_ADDRESS', 'ecopointssuporte@gmail.com'));

        try {
            // Tenta enviar prioritariamente usando o mailer dedicado fale_conosco
            $mailer = config('mail.mailers.fale_conosco') ? 'fale_conosco' : config('mail.default');

            Mail::mailer($mailer)
                ->to($destinatario)
                ->send(new ContatoRecebidoMail(
                    nome: $dados['nome'],
                    email: $dados['email'],
                    assunto: $dados['assunto'],
                    mensagem: $dados['mensagem']
                ));

            return redirect()
                ->route('publico.contato')
                ->with('success', 'Sua mensagem foi enviada com sucesso! Em breve nossa equipe de suporte entrará em contato.');
        } catch (Throwable $e) {
            Log::error('Erro ao enviar e-mail de Fale Conosco: ' . $e->getMessage(), [
                'exception' => $e,
                'dados' => [
                    'nome' => $dados['nome'],
                    'email' => $dados['email'],
                    'assunto' => $dados['assunto'],
                ],
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Não foi possível enviar sua mensagem no momento. Por favor, tente novamente ou envie diretamente para ' . $destinatario . '.');
        }
    }
}
