<?php

namespace App\Mail;

use App\Models\Quote;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class QuoteSentMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Quote $quote) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Uw offerte staat klaar'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.quote-sent',
            with: [
                'quote' => $this->quote,
                'approveUrl' => URL::signedRoute('quotes.approve', $this->quote),
                'rejectUrl' => URL::signedRoute('quotes.reject', $this->quote),
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

        if (! $this->quote->url) {
            return [];
        }

        return [
            Attachment::fromStorageDisk('public', $this->quote->url)
                ->as("Offerte-{$this->quote->id}.pdf")
                ->withMime('application/pdf'),
        ];
    }
}
