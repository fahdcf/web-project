<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class filiere extends Model
{
    protected $fillable = ['name','department_id', 'coordonnateur_id',]; 

    public function coordonnateur(){
        return $this->belongsTo(User::class, 'coordonnateur_id');
    }

    public function departement(){
        return $this->belongsTo(Departement::class, 'department_id');
    }
}
