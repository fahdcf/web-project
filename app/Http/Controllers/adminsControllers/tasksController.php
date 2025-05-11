<?php

namespace App\Http\Controllers\adminsControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\task;

class tasksController extends Controller
{
    public function addtask()
    {
        request()->validate([

            'task' => 'required',
        ]);

   }

   public function markAsDone($id){
    $task=task::findOrFail($id);
    $task->isdone=1;
    $task->save();
    return redirect()->back();
   }
   
   public function markAsPending($id){
    $task=task::findOrFail($id);
    $task->isdone=0;
    $task->save();
    return redirect()->back();
   }


   public function delete($id){
    $task=task::findOrFail($id);
    $task->delete();
    return redirect()->back();

   }
}
