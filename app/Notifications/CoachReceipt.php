<?php

declare(strict_types=1);

namespace Treiner\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * This notification is sent to the coach when a session is done and the money has been sent off.
 */
class CoachReceipt extends Notification implements ShouldQueue
{
    use Queueable;

    protected $session;
    protected $coachName;
    protected $paymentMethod;

    /**
     * Create a new notification instance.
     */
    public function __construct($session, $coachName, $paymentMethod)
    {
        $this->session = $session;
        $this->coachName = $coachName;
        $this->paymentMethod = $paymentMethod;
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
        ->subject('Payment receipt for your session')
        ->markdown('mail.coach-receipt', 
            ['session' => $this->session,
             'coachName' => $this->coachName,
             'paymentMethod' => $this->paymentMethod,
            ]
        );
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return [
            'session' => $this->session,
            'coachName' => $this->coachName,
            'paymentMethod' => $this->paymentMethod,
        ];
    }
}
