<?php

namespace Treiner\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class JobPostInvitation extends Notification implements ShouldQueue
{
    use Queueable;

    protected $jobPostInvitation;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($jobPostInvitation)
    {
        $this->jobPostInvitation = $jobPostInvitation;
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
        return (new MailMessage)
        ->subject('A player has requested you for a session')
        ->markdown('mail.job-invitation', 
            [  
                'user' => $notifiable,
                'jobInvitation' => $this->jobPostInvitation,
            ]
        );     
    }

    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())->content('A player, ' . $this->jobPostInvitation->jobPost->player->user->name . ', has requested you for a session. Please visit ' . route('invitations.index') . ' to view more.');
    }
}
