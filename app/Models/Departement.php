<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    // Relationships
    public function chef()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
