<?php

namespace Treiner\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Treiner\JobOffer;

class JobApplication extends Notification implements ShouldQueue
{
    use Queueable;

    protected $jobOffer;

    /**
     * Create a new notification instance.
     *
     * @param JobOffer $jobOffer
     * @return void
     */
    public function __construct($jobOffer)
    {
        $this->jobOffer = $jobOffer;
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
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('You have received a new application for your job')
        ->markdown('mail.job-application',
            [
                'playerName' => $notifiable->first_name,
                'jobOffer' => $this->jobOffer,
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
            'playerName' => $notifiable->first_name,
            'jobOffer' => $this->jobOffer, 
        ];
    }
}
