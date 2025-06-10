<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function professor()
    {
        return $this->belongsTo(User::class, 'prof_id');
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function studentModuleNotes()
    {
        return $this->hasMany(StudentModuleNote::class, 'note_id');
    }

      public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }
}
