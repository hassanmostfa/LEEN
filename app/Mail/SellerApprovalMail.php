<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Sellers\Seller;

class SellerApprovalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $seller;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Seller $seller)
    {
        $this->seller = $seller;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'الموافقة على طلب انضمام بائع جديد',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.seller_approval',
            with: ['seller' => $this->seller], // Passing seller data to the view
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
