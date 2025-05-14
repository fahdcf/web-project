<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class user_detail extends Model
{
  protected $fillable = ['user_id', 'status', 'date_of_birth', 'adresse', 'number', 'cin', 'hhhh', 'sexe', 'hours', 'profile_img'];
  public function user()
  {
    return  $this->belongsTo(User::class, 'user_id');
  }
}
