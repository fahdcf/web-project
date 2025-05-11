<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\Role;
use App\Models\User;
use App\Models\user_detail;

class adminsController extends Controller
{
    public function index()
    {
        $departments = Departement::all();
        $admins = User::where('role_column', 'admin')->paginate(10);

        return view('admin.admins', ['admins' => $admins, 'Departements' => $departments]);

    }

    public function showadd()
    {
        $departments = Departement::all();
        $professeurs = User::where('role_column', 'professor')->get();

        return view('admin.add_admin', ['professeurs' => $professeurs, 'Departements' => $departments]);

    }

    public function add()
    {

        request()->validate([
            'firstname' => 'required|string|max:255|min:2',
            'lastname' => 'required|string|max:255|min:2',
            'email' => 'required|email',
            'password' => 'required',
            'status' => 'required',
            'hours' => 'required|numeric',
            'departement' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'adresse' => 'nullable|string|max:255',
            'tele' => 'nullable|numeric',
            'cin' => 'nullable|max:20',
            'sexe' => 'nullable|in:male,female',

        ]);

        $userdata = [
            'firstname' => request('firstname'),
            'lastname' => request('lastname'),
            'email' => request('email'),
            'password' => password_hash(request('password'), PASSWORD_BCRYPT),
            'role_column' => 'admin',
            'departement' => request('departement'),

        ];

        $newadmin = User::create($userdata);
        Role::create(['user_id' => $newadmin->id, 'isprof' => 1, 'isadmin' => 1]);

        $userdetails = [
            'user_id' => $newadmin->id,
            'status' => request('status'),
            'date_of_birth' => request('date'),
            'adresse' => request('adresse'),
            'number' => request('tele'),
            'cin' => request('cin'),
            'sexe' => request('sexe'),
            'hours' => request('hours'),

        ];

        if (request()->hasFile('profile_img')) {
            $profileImgPath = request()->file('profile_img')->store('images/profile', 'public');
            $userdetails['profile_img'] = $profileImgPath;

        }

        user_detail::create($userdetails);

        return redirect('admins');

    }

    public function choose()
    {
        request()->validate([
            'professeur_id' => 'required',
        ]);

        $prof = User::findOrFail(request('professeur_id'));
        $prof->role_column = 'admin';

        if ($prof->role) {
            $prof->role->isadmin = 1;
            $prof->save();
        } else {
            $prof->save();
            Role::create(['user_id' => $prof->id, 'isadmin' => 1, 'isprof' => 1]);
        }

        return redirect('admins');
    }

    public function showmodify($id)
    {

        $admin = User::find($id);

        return view('admin.modify_admins', ['admin' => $admin]);

    }

    public function modify($id)
    {

        request()->validate([
            'firstname' => 'required|string|max:255|min:2',
            'lastname' => 'required|string|max:255|min:2',
            'email' => 'required|email|max:255',
            'status' => 'required',

        ]);

        $admin = User::where('id', $id)->first();
        $admin->firstname = request('firstname');
        $admin->lastname = request('lastname');

        if (request('password') != null) {
            $admin->password = password_hash(request('password'), PASSWORD_BCRYPT);

        }

        if ($admin->email != request('email')) {

            $emailexit = User::where('email', request('email'))->first();

            if (! $emailexit) {

                $admin->email = request('email');
            } else {

                return redirect()->back()->withErrors('email exist');
            }

        }
        if ($admin->user_details) {

            $admin_details = user_detail::where('user_id', $id)->first();

            $admin_details->status = request('status');

            if (request()->hasFile('profile_img')) {
                $profileImgPath = request()->file('profile_img')->store('images/profile', 'public');

                $admin_details->profile_img = $profileImgPath;
            }
            $admin_details->save();

        } else {

            $userdetails = [
                'user_id' => $admin->id,
                'status' => request('status'),

            ];

            if (request()->hasFile('profile_img')) {
                $profileImgPath = request()->file('profile_img')->store('images/profile', 'public');
                $userdetails['profile_img'] = $profileImgPath;

            }

            user_detail::create($userdetails);

        }

        $admin->save();

        return redirect('admins');
    }

    public function filter()
    {
        $query = User::where('role_column', 'admin');

        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('firstname', 'like', "%$search%")
                    ->orWhere('lastname', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");

            });
        }

        if (request('departement')) {
            $departement = request('departement');
            $query->where('departement', $departement);
        }
        if (request('status')) {
            $status = request('status');
            $query->whereHas('user_details', function ($q) use ($status) {
                $q->where('status', $status);
            });
        }

        $rows = request('rows', 5); // default to 5 if not provided

        $admins = $query->with('user_details')->simplePaginate($rows);
        $departments = Departement::all();

        return view('admin.admins', ['admins' => $admins, 'Departements' => $departments]);

    }

    public function delete($id)
    {
        User::find($id)->delete();

        return redirect()->back();
    }
}
