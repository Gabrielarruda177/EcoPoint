<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OngCredenciaisMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Cria uma nova instância de mensagem com as credenciais da ONG.
     */
    public function __construct(
        public string $nome,
        public string $email,
        public string $senhaTemporaria
    ) {}

    /**
     * Define o envelope do e-mail (remetente, assunto, etc.).
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bem-vindo ao EcoPoint - Seus dados de acesso'
        );
    }

    /**
     * Define o conteúdo da mensagem e a view correspondente.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.ongs.credenciais'
        );
    }
}
