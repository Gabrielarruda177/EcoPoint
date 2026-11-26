<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContatoRecebidoMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Cria uma nova instância da mensagem de contato enviada pelo usuário.
     *
     * @param string $nome Nome do remetente
     * @param string $email E-mail do remetente
     * @param string $assunto Assunto da mensagem
     * @param string $mensagem Conteúdo da mensagem
     * @param string|null $dataEnvio Data e hora formatada do envio
     */
    public function __construct(
        public string $nome,
        public string $email,
        public string $assunto,
        public string $mensagem,
        public ?string $dataEnvio = null
    ) {
        $this->dataEnvio = $this->dataEnvio ?? now()->format('d/m/Y H:i:s');
    }

    /**
     * Define o envelope do e-mail com remetente, assunto e Reply-To.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[Fale Conosco - EcoPoint] ' . $this->assunto,
            replyTo: [
                new Address($this->email, $this->nome),
            ],
        );
    }

    /**
     * Define o conteúdo da mensagem e a view correspondente.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contato',
        );
    }
}
