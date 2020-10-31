<?php

declare(strict_types=1);

namespace Treiner\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * This notification is sent to a player to remind them to review their sessions
 */
class ReviewReminder extends Notification implements ShouldQueue
{
    use Queueable;

    protected $url;

    protected $player;

    protected $coach;

    /**
     * Create a new notification instance.
     */
    public function __construct($url, $player, $coach)
    {
        $this->url = $url;
        $this->player = $player;
        $this->coach = $coach;
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
                ->subject('Review your session')
                ->markdown('mail.review-reminder', 
                    ['url' => $this->url, 
                     'player' => $this->player, 
                     'coach' => $this->coach]
                );
    }
}
