<?php

namespace Treiner\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CoachDenied extends Notification implements ShouldQueue
{
    use Queueable;
    protected $denyReason;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $denyReason)
    {
        $this->denyReason = $denyReason;
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
        ->subject('Your application to join Treiner has been denied')
        ->markdown('mail.coach-denied', 
            ['denyReason' => $this->denyReason,
             'user' => $notifiable,
            ]
        );    
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'user' => $notifiable,
            'denyReason' => $this->denyReason
        ];
    }
}
