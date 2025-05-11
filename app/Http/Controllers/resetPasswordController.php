<?php

namespace App\Http\Controllers;

use App\Mail\resetPasswordEmail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class resetPasswordController extends Controller
{
    public function index()
    {
        return view('password_reset');
    }

    public function reset()
    {
        $data = request()->validate([
            'reset_email' => ['required', 'email'],
        ]);

        $user = User::where('email', $data['reset_email'])->first();

        if (! $user) {
            return redirect()->back()->withErrors([
                'reset_email' => 'Account not found',
            ])->withInput();
        }

        $generatedcode = rand(10000, 99999);

        session(['code' => $generatedcode, 'reset_email' => request('reset_email')]);

        Mail::to(['mohssineechlaihi85@gmail.com', 'joihfah@gmail.com'])->queue(new resetPasswordEmail($generatedcode));

        return redirect('/reset_password?validation_code');
    }

    public function validate()
    {

        request()->validate([
            'entered_code' => ['required'],

        ]);

        if (session('code') == request('entered_code')) {

            return redirect('/reset_password?new_password');

        } else {
            return redirect()->back()->withErrors([
                'entered_code' => 'Code non valid',
            ])->withInput();

        }

        //   return view("password_reset");
    }

    public function newpassword()
    {
        request()->validate([
            'password' => ['required', 'confirmed'],

        ]);

        $user = User::where('email', session('reset_email'))->first();

        if ($user) {
            $user->password = Hash::make(request('password'));
            $user->save();

            session()->forget('reset_email');

            return redirect('login')->with('success', 'Mot de passe mis à jour avec succès !');
        } else {
            return dd('user not found');
        }

        //   return view("password_reset");
    }
}
