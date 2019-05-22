<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Beneficiary extends Model
{
  use HasApiTokens;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'lastname_one', 'lastname_two', 'name', 'birthdate', 'gender', 'folio', 'group_id'
  ];

  public function group()
  {
    return $this->belongsTo('App\Group')->with('user');
  }

  public function ytt1_evaluations()
  {
    return $this->hasMany('App\Ytt1Evaluation');
  }

  public function ytt1_draft()
  {
    return $this->hasOne('App\YTT1Draft'); 
  }

  public function ytt2_evaluations()
  {
    return $this->hasMany('App\Ytt2Evaluation');
  }

  public function ytt2_draft()
  {
    return $this->hasOne('App\YTT2Draft'); 
  }
}
