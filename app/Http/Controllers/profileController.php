<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\User;

class profileController extends Controller
{
    public function index()
    {

        if (optional(auth()->user()->role)->isadmin) {

            return view('admin.admin_profile');
        } else {
            return view('user_profile');

        }
    }

    public function otherprofile($id)
    {
        $user = User::findOrFail($id);
        $departments = Departement::all();

        if ((optional(auth()->user()->role)->isadmin)) {

            return view('admin.admin_user_profile', ['user' => $user, 'Departements' => $departments]);
        } else {
            return view('other_profile', ['user' => $user]);

        }
    }

    public function editimage($id)
    {

        $user = user::find($id);
        $userdetails = $user->user_details;
        $userdetails->profile_img;

        if (request()->hasFile('profile_img')) {
            $profileImgPath = request()->file('profile_img')->store('images/profile', 'public');

            $userdetails->profile_img = $profileImgPath;
        }

        $userdetails->save();

        return redirect()->back();
    }

    public function deleteimage($id)
    {

        $user = user::find($id);
        $userdetails = $user->user_details;
        $userdetails->profile_img;

        $userdetails->profile_img = null;

        $userdetails->save();

        return redirect()->back();

    }
}
