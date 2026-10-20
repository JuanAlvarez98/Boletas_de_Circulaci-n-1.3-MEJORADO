<?php

namespace App\Mail;

use App\Models\ActaEntrega;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ActaEntregaMail extends Mailable
{
    use Queueable, SerializesModels;

    public ActaEntrega $acta;

    /**
     * Create a new message instance.
     */
    public function __construct(ActaEntrega $acta)
    {
        $this->acta = $acta->loadMissing(['vehicle', 'boleta', 'registradoPor']);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $placa = $this->acta->vehicle ? $this->acta->vehicle->placa : 'S/P';

        return new Envelope(
            subject: "Acta de Entrega Oficial [{$this->acta->folio}] - Vehículo {$placa} - SIG",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.acta-entrega',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
