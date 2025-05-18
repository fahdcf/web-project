<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'module_id',
        'semester',
        'session_type',
        'note',
        'remarks'
    ];


    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }


    public function module()
    {
        return $this->belongsTo(Module::class);
    }


    public function scopeForSemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }


    public function scopeForSessionType($query, $type)
    {
        return $query->where('session_type', $type);
    }

    public function scopeForModule($query, $moduleId)
    {
        return $query->where('module_id', $moduleId);
    }

    
    public function getFormattedSessionTypeAttribute()
    {
        return $this->session_type === 'normale' ? 'Session Normale' : 'Session Rattrapage';
    }

    public function getFormattedNoteAttribute()
    {
        return number_format($this->note, 2);
    }
}
