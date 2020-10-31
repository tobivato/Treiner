<?php

namespace Treiner\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;
use Treiner\JobPost;
use Treiner\NewsletterSubscription;

class NewJobNearCoach extends Notification implements ShouldQueue
{
    use Queueable;
    protected $jobPost;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(JobPost $jobPost)
    {
        $this->jobPost = $jobPost;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', TwilioChannel::class];
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
        ->subject('A new coaching job has been posted near you!')
        ->markdown('mail.new-job-post', 
            [  
                'user' => $notifiable,
                'job' => $this->jobPost,
                //'unsub_link' => $unsub_link,
            ]
        );         
    }

    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())->content('Hi ' . $notifiable->first_name . ', a player, ' . $this->jobPost->player->user->name . ', has posted a new coaching job near you. View it at ' . route('jobs.show', $this->jobPost));
    }
}
