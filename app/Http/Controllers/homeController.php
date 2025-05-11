<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class homeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            /** @var \Illuminate\Contracts\Auth\Factory $auth */
            if (auth()->user()->role_column == 'admin') {
                $studentCount = User::where('role_column', 'student')->count();
                $professorCounts = User::where('role_column', 'professor')->count();

                $tasks = task::where('user_id', auth()->user()->id)
                    ->latest()
                    ->take(5)
                    ->get();

                return view('admin.admin_dashboard', [
                    'tasks' => $tasks,
                    'studentCount' => $studentCount,
                    'professorCount' => $professorCounts
                ]);
            }
            // if coordinator
            if (auth()->user()->isCoordonnateur()) {
                return redirect()->route('coordonnateur.dashboard');
            } 


             // if professor
             if (auth()->user()->isProfessor()) {
                return redirect()->route('professor.dashboard');
            } 
            else {
                return view('dashboard');
            }
        } else {
            return redirect('login');
        }
    }
}
