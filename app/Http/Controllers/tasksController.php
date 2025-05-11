<?php

namespace App\Http\Controllers;

use App\Models\task;

class tasksController extends Controller
{
    public function addtask()
    {
        request()->validate([

            'task' => 'required',
        ]);

        $newtask = ['description' => request('task'), 'user_id' => auth()->user()->id];
        task::create($newtask);

        return redirect()->back();

    }
}
