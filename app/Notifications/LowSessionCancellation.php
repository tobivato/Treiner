<?php

namespace Treiner\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class LowSessionCancellation extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Session to remind this player is being cancelled
     *
     * @var \Treiner\Session
     */
    protected $session;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($session)
    {
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
        ->subject('Your session with ' . $this->session->coach->user->name . ' has been cancelled')
        ->markdown('mail.low-session-cancellation', 
            [  
                'user' => $notifiable,
                'session' => $this->session,
            ]
        );   
    }
}
