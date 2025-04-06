<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\pending_user;
use Illuminate\Support\Facades\Auth;

use App\Mail\newuserEmail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;
use App\Http\Controllers\newuserController;

use App\Http\Controllers\pendinguserController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use PDO;
use PDOException;

class registrationController extends Controller
{
    public function index(){
        return view('signup');
    }
    public function store(Request $request){

         // Validate input
    $validator = Validator::make(request()->all(), [
        'firstname' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:pending_users,email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // If validation fails, redirect back with errors and input
    if ($validator->fails()) {
        return Redirect::to('/registration?failed')
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
        
        Mail::to("joihfah@gmail.com")->queue(new NewuserEmail($pendinguser));
        // Redirect to success page with success message
       


        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return  redirect()->route('pendinguser', ['user' => $pendinguser]);




    } catch (PDOException $e) {
        die("Database Error: " . $e->getMessage());
    }
  
    }
    public function login(){
         // Validate input
    $validator = Validator::make(request()->all(), [
        'login_email' => 'required|email',
        'login_pwd' => 'required',
   ]);

    // If validation fails, redirect back with errors and input
    if ($validator->fails()) {
        return Redirect::back()
            ->withErrors($validator) // Send validation errors to session
            ->withInput(); 
    }

    // Get validated data
    $validated = $validator->validated();
    
    try {
        $pdo = DB::connection()->getPdo();
        
        $query = 'SELECT * FROM pending_users WHERE email=:email;';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $validated['login_email']);
        $stmt->execute();
        $pendinguser = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($pendinguser) {
            if (password_verify($validated['login_pwd'], $pendinguser['pwd'])) {

                return redirect()->route('pendinguser', ['user' => $pendinguser]);


               // return view('pendinguser',['user'=>$pendinguser]) ;
            } else {
                return Redirect::to('/registration?failed')
                    ->withErrors(['login_pwd' => 'Incorrect password.'])
                    ->withInput(); // Return error for incorrect password
            }
        }
        
        
        else {
            // If the user doesn't exist in the pending_users table, check the users table
            $query = 'SELECT * FROM users WHERE email=:email;';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':email', $validated['login_email']);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if the user exists in the users table
            if ($user) {
                // Verify the password for the user
                if (password_verify($validated['login_pwd'], $user['password'])) {
                    
                    auth::loginUsingId($user['id']);

                    return Redirect::to('/')
                        ->with('success', 'Login successful!');
                } else {
                    return Redirect::to('/registration?failed')
                        ->withErrors(['login_pwd' => 'Incorrect password.'])
                        ->withInput(); // Return error for incorrect password
                }
            } else {
                return Redirect::to('/registration?failed')
                    ->withErrors(['login_email' => 'Account not found.'])
                    ->withInput(); // Return error for non-existent email
            }
        }


    } catch (PDOException $e) {
        // For database errors, redirect back with a generic error message
        return Redirect::to('/registration?failedbadly')
            ->withErrors(['error' => 'Login failed. Please try again.'])
            ->withInput();
    }
    }
}
