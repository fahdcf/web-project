<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class chef_action extends Model
{
protected $guarded =[];

public function user(){
    return  $this->belongsTo(User::class,'chef_id');
  }
}
