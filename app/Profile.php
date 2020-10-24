<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
  protected $fillable = [
      'first_name','photo','last_name', 'email', 'user_id',
  ];
}
