<?php

namespace Treiner\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Treiner\Coach;

class AccountCreated extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if ($notifiable->role instanceof Coach) {
            return (new MailMessage)
            ->subject('Thanks for signing up with Treiner')
            ->markdown('mail.new-coach', 
                [
                 'name' => $notifiable->name, 
                ]
            );
        }
        return (new MailMessage)
        ->subject('Thanks for signing up with Treiner!')
        ->markdown('mail.new-player', 
            [
             'name' => $notifiable->name, 
            ]
        );
    }
}
