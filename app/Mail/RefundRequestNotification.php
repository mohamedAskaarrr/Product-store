<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RefundRequestNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $order;
    public $reason;
    public $token;

    public function __construct($user, $order, $reason, $token)
    {
        $this->user = $user;
        $this->order = $order;
        $this->reason = $reason;
        $this->token = $token;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Refund Request for Order #' . $this->order->order_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.refund-request',
        );
    }
} 