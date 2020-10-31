<?php

namespace Treiner\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Treiner\NewsletterSubscription;

class NearbyJobsReminder extends Notification implements ShouldQueue
{
    use Queueable;
    protected $jobs;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($jobs)
    {
        $this->jobs = $jobs;
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
        //$unsub_link = NewsletterSubscription::find($notifiable->email)->unsub_token;
        return (new MailMessage)
        ->subject('Coaching jobs near you')
        ->markdown('mail.nearby-jobs', 
            [
                'jobs' => $this->jobs,
                'user' => $notifiable,
                //'unsub_link' => $unsub_link,
            ]
        );   
    }
}
