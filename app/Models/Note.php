<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function professor()
    {
        return $this->belongsTo(User::class);
    }


      public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }
}
