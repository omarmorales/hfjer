<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class QuestionMail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $title;
    public $description;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $title, $description)
    {
        $this->user = $user;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Duda sobre la YTT App')->markdown('emails.question');
    }
}
