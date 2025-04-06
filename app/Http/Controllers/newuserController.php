<?php
namespace App\Http\Controllers;

use App\Services\BrevoMailService;

class newuserController extends Controller
{
    protected $mailService;

    // Inject the BrevoMailService into the controller
    public function __construct(BrevoMailService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function sendNewUserEmail()
    {
        $newUser = [
            'firstname' => 'Test User',
            'email' => 'testuser@example.com',
        ];

        $subject = 'New User Notification';
        $message = view('emails.newuser', compact('newUser'))->render();

        // Call the BrevoMailService to send the email
        $this->mailService->sendEmail("admin@example.com", $subject, $message);

        return "Test email sent via API!";
    }
}
