<?php

declare(strict_types=1);

namespace Treiner\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Contact extends Mailable
{
    use Queueable;
    use SerializesModels;

    protected $name;
    protected $email;
    protected $content;
    /**
     * Create a new message instance.
     */
    public function __construct($name, $email, $content)
    {
        $this->name = $name;
        $this->email = $email;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.contact', [
            'name' => $this->name,
            'email' => $this->email,
            'content' => $this->content,
        ]);
    }
}
