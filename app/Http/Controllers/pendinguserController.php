<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pendinguserController extends Controller
{
    public function show(Request $request)
{
    $pendinguser = $request->user; // Retrieve the user data passed during the redirect
    return view('pendinguser', ['user' => $pendinguser]);
}
}
