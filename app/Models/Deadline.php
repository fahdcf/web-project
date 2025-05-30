<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deadline extends Model
{
    protected $guarded = [];

    protected $casts = [
        'deadline_date' => 'datetime',
        'notification_date' => 'datetime',
    ];

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}