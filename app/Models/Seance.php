<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seance extends Model


{
    protected $table = 'seances';


    protected $guarded = [];

    
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function emploi()
    {
        return $this->belongsTo(Emploi::class);
    }
}
