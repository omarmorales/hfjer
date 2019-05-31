<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Organization extends Model
{
  use HasApiTokens;

  protected $fillable = [
    'name', 'description'
  ];

  public function users()
  {
    return $this->hasMany('App\User');
  }

  public function groups()
  {
    return $this->hasMany('App\Group')->with('beneficiaries');
  }
}
