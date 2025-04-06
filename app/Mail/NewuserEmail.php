<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewuserEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user; // Fix variable name

    /**
     * Create a new message instance.
     */
    public function __construct($newuser)
    {
        $this->user = $newuser;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('New User Registered')
                    ->view('emails.newuser') // Fix view name
                    ->with(['user' => $this->user]);
    }
}
