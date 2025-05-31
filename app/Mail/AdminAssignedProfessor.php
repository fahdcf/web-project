<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminAssignedProfessor extends Mailable
{
    use Queueable, SerializesModels;

    public $firstname;
    public $lastname;

    /**
     * Create a new message instance.
     *
     * @param string $firstname
     * @param string $lastname
     */
    public function __construct($firstname, $lastname)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Vous avez été nommé administrateur sur AssignPro')
                    ->view('emails.admin_assigned_professor');
    }
}