<?php

declare(strict_types=1);

namespace Treiner\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * This notification is sent to the coach when a player has withdrawn from their session
 */
class PlayerWithdraw extends Notification implements ShouldQueue
{
    use Queueable;

    protected $name;
    protected $type;
    protected $location;
    protected $starts;

    /**
     * Create a new notification instance.
     */
    public function __construct($name, $type, $location, $starts)
    {
        $this->name = $name;
        $this->type = $type;
        $this->location = $location;
        $this->starts = $starts;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @return Treiner\Mail\PlayerWithdraw
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('A player has withdrawn from your session')
        ->markdown('mail.player-withdraw',
            [
                'location' => $this->location,
                'name' => $this->name,
                'starts' => $this->starts,
                'type' => $this->type
            ]
        );  
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return [
            'name' => $this->name,
            'type' => $this->type,
            'location' => $this->location,
            'starts' => $this->starts,
        ];
    }
}
