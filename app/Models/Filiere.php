<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    // Academic programs (belong to a department)
    protected $fillable = ['name', 'department_id', 'coordonnateur_id', 'description'];

    use HasFactory;

    public function department()
    {
        return $this->belongsTo(Departement::class, 'department_id');
    }

    // ///////////////////////////////
    public function coordonnateur()
    {
        return $this->hasOne(User::class, 'coordonnateur_id');
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function professors()
    {
        return $this->belongsToMany(User::class)->whereHas('role', function ($q) {
            $q->where('isprof', true);
        });
    }
}
