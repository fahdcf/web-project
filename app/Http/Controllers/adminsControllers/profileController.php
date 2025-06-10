<?php

namespace App\Http\Controllers\adminsControllers;
use App\Http\Controllers\Controller;

use App\Models\Module;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\user_detail;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use App\Models\Departement;
use App\Models\filiere;
use App\Models\Role;

use Illuminate\Support\Facades\Notification;
use App\Notifications\ProfUnassignedNotification;
class profileController extends Controller
{
    public function index(){

        if(optional(auth()->user()->role)->isadmin){

            return view('admin.admin_profile');
        }
        else{
            return view('user_profile');
    
        }
}

public function otherprofile($id){
    $user=User::findOrFail($id);
    $departments=Departement::whereNot('id',1)->get();

    if((optional(auth()->user()->role)->isadmin)){

        return view('admin.admin_user_profile',['user'=>$user,'Departements'=>$departments]);
    }
    else{
    $user=User::findOrFail($id);

        return view('other_profile',['user'=>$user]);

    }
}

public function editimage($id){
    
    $user=user::find($id);
    $userdetails=$user->user_details;
    $userdetails->profile_img;

if (request()->hasFile('profile_img')) {
    $profileImgPath = request()->file('profile_img')->store('images/profile', 'public');
    
    $userdetails->profile_img=$profileImgPath;
}

$userdetails->save();

return redirect()->back();
}

public function deleteimage($id){
    
    
    $user=user::find($id);
    $userdetails=$user->user_details;
    $userdetails->profile_img;


    $userdetails->profile_img=null;


$userdetails->save();

return redirect()->back();

}
}
