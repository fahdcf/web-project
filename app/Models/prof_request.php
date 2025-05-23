<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class prof_request extends Model
{

    protected $guarded = [];



    public function module()
    {
        return $this->belongsTo(Module::class);
    }
    public function prof()
    {
        return $this->belongsTo(User::class, 'prof_id');
    }


    public function getTargetAttribute()
    {
        return Module::find($this->module_id);
    }
}
