<?php

namespace App\Http\Controllers\adminsControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\pending_user;

class pendinguserController extends Controller
{
    public function show(Request $request)
    {
        $pendingusers = pending_user::all();

        return view('admin.pending_users', ['pending_users' => $pendingusers]);

    }
}
