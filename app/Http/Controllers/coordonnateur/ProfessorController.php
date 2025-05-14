<?php

namespace App\Http\Controllers\coordonnateur;

use App\Http\Controllers\Controller;

class ProfessorController extends Controller
{
    public function index() {
        return view('professor.index');
    }
}
