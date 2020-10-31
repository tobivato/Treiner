<?php

declare(strict_types=1);

namespace Treiner\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Treiner\Session;

class SessionWithdraw extends Notification implements ShouldQueue
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
        ->subject('Session withdrawal')
        ->markdown('mail.session-withdraw', 
            [
                'session' => $this->session,
                'userName' => $notifiable->first_name
            ]
        );
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return [
            'user_name' => $notifiable->first_name,
            'session' => $this->session,
        ];
    }
}
