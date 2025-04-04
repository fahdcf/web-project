<?php

use Illuminate\Support\Facades\Route;

Route::get('/registration', function () {
    return view('signup');
});

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

Route::post('/signup', function() {
    // Validate input
    $validator = Validator::make(request()->all(), [
        'firstname' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
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
        
        // Hash the password before storing
        $hashedPassword = password_hash($validated['password'], PASSWORD_BCRYPT);
        
        $query = 'INSERT INTO users(name, lastname, email, password) 
                 VALUES(:firstname, :lastname, :email, :password)';
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':firstname', $validated['firstname']);
        $stmt->bindParam(':lastname', $validated['lastname']);
        $stmt->bindParam(':email', $validated['email']);
        $stmt->bindParam(':password', $hashedPassword);
        
        $stmt->execute();
        
        // Redirect to success page with success message
        return Redirect::to('/signup-success')
            ->with('success', 'Registration successful!');
        
    } catch (Exception $e) {
        // For database errors, redirect back with error message
        return Redirect::back()
            ->with('error', 'Registration failed. Please try again.')
            ->withInput();
    }
});




Route::post('/login', function() {
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
        
        // Query to get the user based on email
        $query = 'SELECT * FROM users WHERE email=:email;';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $validated['login_email']);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if user exists and verify password
        if ($user) {
            if (password_verify($validated['login_pwd'], $user['password'])) {
                // Redirect to home/dashboard page after successful login
                return Redirect::to('/registration') // Change this to the page you want to redirect to
                    ->with('success', 'Login successful!');
            } else {
                return Redirect::back()
                    ->withErrors(['login_pwd' => 'Incorrect password.'])
                    ->withInput(); // Return error for incorrect password
            }
        } else {
            return Redirect::back()
                ->withErrors(['login_email' => 'Account not found.'])
                ->withInput(); // Return error for non-existent email
        }

    } catch (Exception $e) {
        // For database errors, redirect back with a generic error message
        return Redirect::back()
            ->withErrors(['error' => 'Login failed. Please try again.'])
            ->withInput();
    }
});
