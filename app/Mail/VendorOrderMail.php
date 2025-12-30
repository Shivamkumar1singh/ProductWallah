<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\Vendor\Vendor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VendorOrderMail extends Mailable 
{
    use Queueable, SerializesModels;

    public $order;
    public $vendor;
    public $items;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, Vendor $vendor, array $items)
    {
        $this->order = $order;
        $this->vendor = $vendor;
        $this->items = $items;
    }

    // public function build()
    // {
    //     return $this->subject('New Order Received')
    //                 ->markdown('emils.vendor.order');
    // }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Order Received',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.vendor.order',
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
