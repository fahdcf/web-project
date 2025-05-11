<?php

namespace App\Http\Controllers;

use App\Mail\newuserEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use PDO;
use PDOException;

class signupController extends Controller
{
    public function index()
    {
        return view('signup');
    }

    public function store(Request $request)
    {

        // Validate input
        $validator = Validator::make(request()->all(), [
            'firstname' => 'required|string|max:255|min:2',
            'lastname' => 'required|string|max:255|min:2',
            'email' => 'required|email|max:255|unique:pending_users,email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // If validation fails, redirect back with errors and input
        if ($validator->fails()) {
            return Redirect::to('/signup?failed')
                ->withErrors($validator) // Send validation errors to session
                ->withInput();
        }

        // Get validated data

        $validated = $validator->validated();
        try {
            $pdo = DB::connection()->getPdo();

            // Hash the password before storing
            $hashedPassword = password_hash($validated['password'], PASSWORD_BCRYPT);

            $query = 'INSERT INTO pending_users(firstname, lastname, pwd, email) 
                 VALUES(:firstname, :lastname, :pwd, :email)';

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':firstname', $validated['firstname']);
            $stmt->bindParam(':lastname', $validated['lastname']);
            $stmt->bindParam(':pwd', $hashedPassword);
            $stmt->bindParam(':email', $validated['email']);

            $stmt->execute();

            $query = 'SELECT * FROM pending_users WHERE email=:email;';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':email', $validated['email']);
            $stmt->execute();
            $pendinguser = $stmt->fetch(PDO::FETCH_ASSOC);

            Mail::to(['mohssineechlaihi85@gmail.com', 'joihfah@gmail.com'])->queue(new NewuserEmail($pendinguser));
            // Redirect to success page with success message

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return redirect()->route('pendinguser', ['user' => $pendinguser]);

        } catch (PDOException $e) {
            exit('Database Error: '.$e->getMessage());
        }

    }
}
