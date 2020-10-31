<?php

declare(strict_types=1);

namespace Treiner\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Treiner\Session;

/**
 * This notification is sent to players when a session is low on players and it's three days from running
 */
class SessionLowPlayers extends Notification implements ShouldQueue
{
    use Queueable;

    protected $session;
    /**
     * Create a new notification instance.
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
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
        ->subject('Your session with ' . $this->session->coach->user->name . ' may be cancelled')
        ->markdown('mail.low-players', 
            [
                'session' => $this->session,
                'playerName' => $notifiable->first_name
            ]
        );
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return [
            'playerName' => $notifiable->name,
            'session' => $this->session,
        ];
    }
}
