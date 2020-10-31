<?php

declare(strict_types=1);

namespace Treiner\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Support extends Mailable
{
    use Queueable;
    use SerializesModels;

    protected $title;
    protected $severity;
    protected $type;
    protected $comments;
    protected $user;
    /**
     * Create a new message instance.
     */
    public function __construct($title, $severity, $type, $comments, $user)
    {
        $this->title = $title;
        $this->severity = $severity;
        $this->type = $type;
        $this->comments = $comments;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.support', [
            'title' => $this->title,
            'severity' => $this->severity,
            'type' => $this->type,
            'comments' => $this->comments,
            'user' => $this->user,
        ]);
    }
}
