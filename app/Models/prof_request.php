<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class prof_request extends Model
{

    protected $guarded = [];
    protected $table = "requests"; //le nom du table concerne pouisque pas meme nom du model



    public function module() {
        return $this->belongsTo(Module::class,'target_id');
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