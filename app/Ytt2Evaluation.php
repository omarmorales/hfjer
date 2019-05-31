<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Ytt2Evaluation extends Model
{
  use HasApiTokens;

  protected $fillable = [
      'folio',
      'age',
      'beneficiary_id',
      'answer1',
      'answer2',
      'answer3',
      'answer4',
      'answer5',
      'answer6',
      'answer7',
      'answer8',
      'answer9',
      'answer10',
      'answer11',
      'answer12',
      'answer13',
      'answer14',
      'answer15',
      'answer16',
      'answer17',
      'answer18',
      'answer19',
      'answer20',

      'information1',
      'information2',
      'information3',
      'information4',
      'information5',
      'information6',
      'information7',
      'information8',
      'information9',
      'information10',
      'information11',
      'information12',
      'information13',
      'information14',
      'information15',
      'information16',
      'information17',
      'information18',
      'information19',
      'information20',

      'id_post',
      'risk_level',
      'take_num',
  ];

  public function beneficiary()
  {
    return $this->belongsTo('App\Beneficiary');
  }
}
