<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deadline extends Model
{
    
    protected $fillable = [
        'type',
        'deadline_date',
        'notification_date',
        'status',
        'created_by',
    ];

    protected $casts = [
        'deadline_date' => 'datetime',
        'notification_date' => 'datetime',
    ];
    

  
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}