<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{

    protected $fillable = ['name', 'user_id']; 

    // Relationships
    public function chef()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
