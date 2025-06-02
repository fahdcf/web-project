<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentModuleNote extends Model
{
    protected $table = 'student_notes';

    protected $guarded = [ ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function note()
    {
        return $this->belongsTo(Note::class, 'note_id');
    }
}
