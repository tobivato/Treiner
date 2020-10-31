<?php

declare(strict_types=1);

namespace Treiner\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * This class is used to tell coaches that they've received a new booking when a player books one of their sessions
 */
class Booking extends Notification implements ShouldQueue
{
    use Queueable;

    protected $player;
    protected $session;

    /**
     * Create a new notification instance.
     */
    public function __construct($player, $session)
    {
        $this->player = $player;
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
        ->subject('New booking from ' . $this->player->user->name)
        ->markdown('mail.booking', 
            [
             'coachName' => $notifiable->first_name, 
             'player' => $this->player,
             'session' => $this->session,
            ]
        );
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return [
            'coach_name' => $notifiable->first_name, 
            'player' => $this->player,
            'session' => $this->session,
        ];
    }
}
