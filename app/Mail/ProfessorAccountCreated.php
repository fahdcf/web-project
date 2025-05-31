<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProfessorAccountCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $firstname;
    public $lastname;
    public $password;
    public $email;

    /**
     * Create a new message instance.
     *
     * @param string $firstname
     * @param string $lastname
     * @param string $password
     * @param string $email
     */
    public function __construct($firstname, $lastname, $password, $email)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->password = $password;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Votre compte a été créé')
                    ->view('emails.professor_account_created');
    }
}