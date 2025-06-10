<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    // protected $fillable = [
    //     'firstname',
    //     'lastname',
    //     'status',
    //     'email',
    //     'sexe',
    //     'CNE',
    //     'adress',
    //     'profile_img',
    //     'number',
    //     'date_of_birth',
    //     'filiere_id',
    // ];


    protected $guarded = [];
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'student_module_notes')
            ->withPivot('note', 'session_type', 'semester', 'note_id')
            ->withTimestamps();
    }
}
