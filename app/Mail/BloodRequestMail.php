<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BloodRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $bloodRequest;
    public $receiverName;


    /**
     * Create a new message instance.
     */
    public function __construct($bloodRequest, $receiverName)
    {
        $this->bloodRequest = $bloodRequest;
        $this->receiverName = $receiverName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Blood Request Notification',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.blood_requests',  // Use Blade view instead of direct HTML
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
