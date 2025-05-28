<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id', // Foreign key to modules table
        'prof_id',   // Foreign key to users table (professors or vacataires)
        'hours',
        'teach_cm',
        'teach_tp',
        'teach_td',
        'academic_year',


        // 'start_date', // Optional: Start date of the assignment
        // 'end_date',   // Optional: End date of the assignment

    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'prof_id', 'id');
    }

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id', 'id');
    }
}
