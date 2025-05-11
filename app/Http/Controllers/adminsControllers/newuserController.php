<?php
<<<<<<< HEAD:app/Http/Controllers/newuserController.php

namespace App\Http\Controllers;

=======
namespace App\Http\Controllers\adminsControllers;
use App\Http\Controllers\Controller;
>>>>>>> 84c3551e384ecf403c371018d2ed20ad96f0976e:app/Http/Controllers/adminsControllers/newuserController.php
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
        $this->mailService->sendEmail('admin@example.com', $subject, $message);

        return 'Test email sent via API!';
    }
}
