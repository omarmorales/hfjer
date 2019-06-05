<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use ShiftOneLabs\LaravelCascadeDeletes\CascadesDeletes;

class Group extends Model
{
  use HasApiTokens;
  use CascadesDeletes;

  protected $fillable = [
      'name', 'slug', 'description', 'user_id', 'evaluation', 'organization_id'
  ];

  protected $cascadeDeletes = ['beneficiaries'];

  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public function organization()
  {
    return $this->belongsTo('App\Organization');
  }

  public function beneficiaries()
  {
    return $this->hasMany('App\Beneficiary')->with('ytt1_evaluations')->with('ytt1_draft')->with('ytt2_draft')->with('ytt2_evaluations')->with('group');
  }
}
