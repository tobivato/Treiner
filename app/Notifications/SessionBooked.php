<?php

declare(strict_types=1);

namespace Treiner\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * This notification is sent to players when they've booked a session with the total price etc
 */
class SessionBooked extends Notification implements ShouldQueue
{
    use Queueable;

    protected $sessionPlayers;

    /**
     * Create a new notification instance.
     */
    public function __construct($sessionPlayers)
    {
        $this->sessionPlayers = $sessionPlayers;
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
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('Your session(s) have been booked')
        ->markdown('mail.session-booked', 
            ['playerName' => $notifiable->first_name,
             'sessionPlayers' => $this->sessionPlayers,
            ]
        );
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return [
            'session' => $this->session,
            'coachName' => $this->coachName,
            'playerName' => $notifiable->first_name,
        ];
    }
}
