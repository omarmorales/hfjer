<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use ShiftOneLabs\LaravelCascadeDeletes\CascadesDeletes;

class Organization extends Model
{
  use HasApiTokens;
  use CascadesDeletes;

  protected $fillable = [
    'name', 'description'
  ];

  protected $cascadeDeletes = ['groups', 'users'];

  public function users()
  {
    return $this->hasMany('App\User');
  }

  public function groups()
  {
    return $this->hasMany('App\Group')->with('beneficiaries');
  }
}
