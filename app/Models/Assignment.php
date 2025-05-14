<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id', // Foreign key to modules table
        'user_id',   // Foreign key to users table (professors or vacataires)
        'role',      // Role in the assignment (e.g., 'enseignant', 'responsable')
        'hours',     // Number of hours assigned
        'is_responsible', // Boolean to indicate if this user is the module responsible
        'start_date', // Optional: Start date of the assignment
        'end_date',   // Optional: End date of the assignment
        // Add any other relevant fields
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}