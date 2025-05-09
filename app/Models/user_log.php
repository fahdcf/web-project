<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class user_log extends Model
{
protected $fillable=['user_id','action','ip_adress','user_agent'];

public function user(){
    return  $this->belongsTo(User::class,'user_id');
  }
}
