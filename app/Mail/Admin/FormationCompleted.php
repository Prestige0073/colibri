<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\FormationInscription;

class FormationCompleted extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $inscription;
    public $bestScore;

    /**
     * Create a new message instance.
     */
    public function __construct(FormationInscription $inscription, $bestScore = null)
    {
        $this->inscription = $inscription;
        $this->bestScore = $bestScore;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Formation terminée - Certificat à générer',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.formation-completed',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
