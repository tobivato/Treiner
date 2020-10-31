<?php

declare(strict_types=1);

namespace Treiner\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

/**
 * This notification is sent to players when a session is cancelled by a coach
 */
class SessionCancelled extends Notification implements ShouldQueue
{
    use Queueable;

    protected $coachName;

    protected $session;

    /**
     * Create a new notification instance.
     */
    public function __construct($coachName, $session)
    {
        $this->coachName = $coachName;
        $this->session = $session;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        if ('email' === $notifiable->notification_preference) {
            return ['mail'];
        }

        return [TwilioChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('Your session with ' . $this->coachName . ' has been cancelled')
        ->markdown('mail.session-cancelled', 
            [
                'coachName' => $this->coachName,
                'playerName' => $notifiable->first_name,
                'session' => $this->session
            ]
        );
    }

    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())
            ->content('Your session with ' . $this->coachName . ' at ' . $this->session->starts . ' at' . $this->session->location->address . ' has been cancelled. You will receive a full refund.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return [
            'coachName' => $this->coachName,
            'playerName' => $notifiable->first_name,
            'session' => $this->session,
        ];
    }
}
