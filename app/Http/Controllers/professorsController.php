<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\filiere;
use App\Models\Role;
use App\Models\User;
use App\Models\user_detail;
use App\Notifications\ProfUnassignedNotification;
use Illuminate\Support\Facades\Notification;

class professorsController extends Controller
{
    public function index()
    {

        $departments = Departement::all();

        $professors = User::where('role_column', 'professor')
            ->orWhereHas('role', function ($query) {
                $query->where('isprof', true);
            })
            ->simplePaginate(5);

        return view('admin.professeurs', ['professors' => $professors, 'Departements' => $departments]);

    }

    public function filter()
    {
        $departments = Departement::all();

        $query = User::where('role_column', 'professor');

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

        $professors = $query->with('user_details')->simplePaginate($rows);

        return view('admin.professeurs', ['professors' => $professors, 'Departements' => $departments]);

    }

    public function showadd()
    {

        $departements = Departement::all();

        return view('admin.add_professeur', ['Departements' => $departements]);

    }

    public function add()
    {
        request()->validate([
            'firstname' => 'required|string|max:255|min:2',
            'lastname' => 'required|string|max:255|min:2',
            'email' => 'required|email',
            'password' => 'required',
            'status' => 'required',
            'departement' => 'nullable|string|max:255',
            'hours' => 'required|numeric',
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
            'role_column' => 'professor',
            'departement' => request('departement'),

        ];

        $newprof = User::create($userdata);
        Role::create(['user_id' => $newprof->id, 'isprof' => 1]);

        $userdetails = [
            'user_id' => $newprof->id,
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

        return redirect('professeurs');
    }

    public function showmodify($id)
    {

        $professeur = User::find($id);

        return view('admin.modify_professeurs', ['professeur' => $professeur]);

    }

    public function modify($id)
    {

        request()->validate([
            'firstname' => 'required|string|max:255|min:2',
            'lastname' => 'required|string|max:255|min:2',
            'email' => 'required|email|max:255',
            'status' => 'required',

        ]);

        $prof = User::where('id', $id)->first();
        $prof->firstname = request('firstname');
        $prof->lastname = request('lastname');

        if (request('password') != null) {
            $prof->password = password_hash(request('password'), PASSWORD_BCRYPT);

        }

        if ($prof->email != request('email')) {

            $emailexit = User::where('email', request('email'))->first();

            if (! $emailexit) {

                $prof->email = request('email');
            } else {

                return redirect()->back()->withErrors('email exist');
            }

        }
        if ($prof->user_details) {

            $prof_details = user_detail::where('user_id', $id)->first();

            $prof_details->status = request('status');

            if (request()->hasFile('profile_img')) {
                $profileImgPath = request()->file('profile_img')->store('images/profile', 'public');

                $prof_details->profile_img = $profileImgPath;
            }
            $prof_details->save();

        } else {

            $userdetails = [
                'user_id' => $prof->id,
                'status' => request('status'),

            ];

            if (request()->hasFile('profile_img')) {
                $profileImgPath = request()->file('profile_img')->store('images/profile', 'public');
                $userdetails['profile_img'] = $profileImgPath;

            }

            user_detail::create($userdetails);

        }

        $prof->save();

        return redirect('professeurs');

    }

    public function delete($id)
    {
        $departement = Departement::where('user_id', $id)->first();
        $filiere = filiere::where('coordonnateur_id', $id)->first();

        User::find($id)->delete();
        if ($departement) {

            $admins = User::where('role_column', 'admin')->get();

            Notification::send($admins, new ProfUnassignedNotification($departement->name, 1, 0));

        } elseif ($filiere) {
            $admins = User::where('role_column', 'admin')->get();

            Notification::send($admins, new ProfUnassignedNotification($filiere->name, 0, 1));

        }

        return redirect()->back();

    }
}
