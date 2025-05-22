<?php

// app/Models/ScheduleItem.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleItem extends Model
{
    protected $fillable = [
        'schedule_id',
        'module_id',
        'group_type',
        'group_number',
        'day_of_week',
        'start_time',
        'end_time',
        'location',
        'professor_id'
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function professor()
    {
        return $this->belongsTo(User::class, 'professor_id');
    }
}
