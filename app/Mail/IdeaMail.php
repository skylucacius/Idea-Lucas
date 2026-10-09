<?php

namespace App\Mail;

use App\Models\Idea;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class IdeaMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Idea $idea;
    public string $sentAt;

    public function __construct(Idea $idea)
    {
        $this->idea = $idea;
        $this->sentAt = now()->format('d/m/Y H:i:s');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->idea->title, // O assunto será o título da ideia
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: "
                <h2>{$this->idea->title}</h2>
                <p><strong>Descrição:</strong> {$this->idea->description}</p>
                <p><strong>Data/Hora de Envio:</strong> {$this->sentAt}</p>
            ",
        );
    }
}