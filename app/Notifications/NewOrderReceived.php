<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Order;

class NewOrderReceived extends Notification
{
    use Queueable;

    public $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        // Use database for the icon/dropdown and mail for alerts
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Order Alert: #' . $this->order->id)
            ->line('A new order has been placed on the platform.')
            ->line('Order Total: ' . number_format($this->order->total_amount, 2))
            ->action('View Order Details', route('orders.show', $this->order->id))
            ->line('Please process this order at your earliest convenience.');
    }

    /**
     * Get the array representation of the notification for the database.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'message'  => 'New order #' . $this->order->id . ' has been placed.',
            'url'      => route('orders.show', $this->order->id),
            'type'     => 'new_order'
        ];
    }
}