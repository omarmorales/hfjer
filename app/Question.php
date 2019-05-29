<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Question extends Model
{
    use HasApiTokens;

    protected $fillable = [
        'title', 'description', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
