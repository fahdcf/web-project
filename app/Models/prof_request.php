<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class prof_request extends Model
{
     public function prof(){
        return $this->belongsTo(User::class, 'prof_id');
    }
     public function getTargetAttribute()
    {
        switch ($this->type) {
            case 'module':
                return Module::find($this->target_id);
            case 'filiere':
                return Filiere::find($this->target_id);
            case 'departement':
                return Departement::find($this->target_id);
            default:
                return null; // Return null if the type doesn't match
        }
    }
}
