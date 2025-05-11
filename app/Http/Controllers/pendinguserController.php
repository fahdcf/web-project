<?php

namespace App\Http\Controllers;

use App\Models\pending_user;
use Illuminate\Http\Request;

class pendinguserController extends Controller
{
    public function show(Request $request)
    {
        $pendingusers = pending_user::all();

        return view('admin.pending_users', ['pending_users' => $pendingusers]);

    }
}
