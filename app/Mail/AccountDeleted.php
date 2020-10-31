<?php

namespace Treiner\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AccountDeleted extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $name;
    protected $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.account-deleted', [
            'name' => $this->name,
            'email' => $this->email,
        ]);
    }
}
