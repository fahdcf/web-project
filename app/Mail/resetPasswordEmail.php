<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class resetPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

   public $code;
    public function __construct($generatedcode)
    {
$this->code= $generatedcode;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset Password Email',
        );
    }

    /**
     * Get the message content definition.
     */

     public function build()
     {
         return $this->subject('Rest Your Password')
                     ->view('emails.resetpassword') // Fix view name
                     ->with(['code' => $this->code]);
     }
}
