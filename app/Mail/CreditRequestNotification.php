<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CreditRequestNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $amount;
    public $reason;
    public $requestId;

    public function __construct($user, $amount, $reason, $requestId)
    {
        $this->user = $user;
        $this->amount = $amount;
        $this->reason = $reason;
        $this->requestId = $requestId;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Credit Request from ' . $this->user->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.credit-request',
        );
    }
}
