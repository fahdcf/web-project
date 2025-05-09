<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\pending_user;
use App\Models\user_log;
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

class loginController extends Controller
{
    public function index(){
        return view('login');
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
   
  
   $pdo = DB::connection()->getPdo();

       
       
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
                   $ip = request()->ip() === '::1' ? '127.0.0.1' : request()->ip();

                   user_log::create(
                       [
                           'user_id'=> $user['id'],
                           'action'=> "s'est connecté",
                           'ip_addres'=> $ip, 
                           'user_agent' => request()->userAgent(),
        
                       ]
                       );
                   
         
                       return Redirect::to('/')
                       ->with('success', 'Login successful!');
                  
               } else {
                   return Redirect::to('/login?failed')
                       ->withErrors(['login_pwd' => 'Incorrect password.'])
                       ->withInput(); // Return error for incorrect password
               }
           } else {
               return Redirect::to('/login?failed')
                   ->withErrors(['login_email' => 'Account not found.'])
                   ->withInput(); // Return error for non-existent email
           }
       }


    public function exit(){
        auth()->logout();
        return view('login');
    }
}
