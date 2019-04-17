<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Group extends Model
{
  use HasApiTokens;

  protected $fillable = [
      'name', 'description', 'user_id', 'evaluation'
  ];

  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public function beneficiaries()
  {
    return $this->hasMany('App\Beneficiary')->with('ytt1_evaluations');
  }
}
