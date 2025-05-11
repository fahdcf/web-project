<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class student extends Model
{
    protected $fillable = [
    'firstname',
    'lastname',
    'status',
    'email',
    'sexe',
    'CNE',
    'adress',
    'profile_img',
    'number',
    'date_of_birth',
    'filiere_id' // if you're assigning this too
];
}
