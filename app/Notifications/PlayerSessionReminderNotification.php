<?php

namespace Treiner\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PlayerSessionReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;
    protected $userName;
    protected $session;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($userName, $session)
    {
        $this->userName = $userName;
        $this->session = $session;
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
        return (new MailMessage)
        ->subject('Your session is coming up!')
        ->markdown('mail.session-reminder', 
            [  
                'userName' => $this->userName,
                'session' => $this->session,
            ]
        );     
    }
}
