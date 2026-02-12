<?php

namespace App\Mail;

use App\Models\Contract;
use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;


class ContractMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Contract $contract, public Invoice $invoice) {}


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Uw contract en factuur staan klaar',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.contracts.sent',
            with: [
                'contract' => $this->contract,
                'invoice' => $this->invoice,
                'approveUrl' => URL::signedRoute('contracts.approve', $this->contract),
                'rejectUrl' => URL::signedRoute('contracts.reject', $this->contract),
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
        if (! $this->contract->pdf_path) {
            return [];
        }

        return [
            Attachment::fromStorageDisk('public', $this->contract->pdf_path)
                ->as("Contract-{$this->contract->id}.pdf")
                ->withMime('application/pdf'),
        ];
    }
}
