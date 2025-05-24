<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderRefunded extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $items;
    public $total;
    public $orderId;

    public function __construct($user, $items, $total, $orderId)
    {
        $this->user = $user;
        $this->items = $items;
        $this->total = $total;
        $this->orderId = $orderId;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Refunded - Order #' . $this->orderId,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-refunded',
        );
    }
} 