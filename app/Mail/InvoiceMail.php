<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;


class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Invoice $invoice) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Factuur {$this->invoice->id} staat klaar",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.invoices.sent',
            with: [
                'invoice' => $this->invoice,
                'approveUrl' => URL::signedRoute('invoices.approve', $this->invoice),
                'rejectUrl' => URL::signedRoute('invoices.reject', $this->invoice),
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if (! $this->invoice->pdf_path) {
            return [];
        }

        return [
            Attachment::fromStorageDisk('public', $this->invoice->pdf_path)
                ->as("Factuur-{$this->invoice->id}.pdf")
                ->withMime('application/pdf'),
        ];
    }
}
