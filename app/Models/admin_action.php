<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class admin_action extends Model
{
    protected $fillable=['admin_id','action_type','description','target_table','target_id'];
public function user(){
    return  $this->belongsTo(User::class,'admin_id');
  }
}
