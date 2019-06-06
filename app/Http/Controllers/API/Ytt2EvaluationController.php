<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ytt2Evaluation;
use Illuminate\Support\Facades\DB;

class Ytt2EvaluationController extends Controller
{
  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct()
  {
    $this->middleware('auth:api');
  }
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    return Ytt2Evaluation::with('beneficiary')->latest()->get();
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    $this->validate($request,[
      'beneficiary_id' => 'required',
      'answer1' => 'required',
      'answer2' => 'required',
      'answer3' => 'required',
      'answer4' => 'required',
      'answer5' => 'required',
      'answer6' => 'required',
      'answer7' => 'required',
      'answer8' => 'required',
      'answer9' => 'required',
      'answer10' => 'required',
      'answer11' => 'required',
      'answer12' => 'required',
      'answer13' => 'required',
      'answer14' => 'required',
      'answer15' => 'required',
      'answer16' => 'required',
      'answer17' => 'required',
      'answer18' => 'required',
      'answer19' => 'required',
      'answer20' => 'required',
    ]);

    $risk_level = (
      intval($request['answer1']) +
      intval($request['answer2']) +
      intval($request['answer3']) +
      intval($request['answer4']) +
      intval($request['answer5']) +
      intval($request['answer6']) +
      intval($request['answer7']) +
      intval($request['answer8']) +
      intval($request['answer9']) +
      intval($request['answer10']) +
      intval($request['answer11']) +
      intval($request['answer12']) +
      intval($request['answer13']) +
      intval($request['answer14']) +
      intval($request['answer15']) +
      intval($request['answer16']) +
      intval($request['answer17']) +
      intval($request['answer18']) +
      intval($request['answer19']) +
      intval($request['answer20'])
    );

    return Ytt2Evaluation::create([
      'folio' => $request['folio'],
      'age' => $request['age'],
      'beneficiary_id' => $request['beneficiary_id'],
      'answer1' => $request['answer1'],
      'answer2' => $request['answer2'],
      'answer3' => $request['answer3'],
      'answer4' => $request['answer4'],
      'answer5' => $request['answer5'],
      'answer6' => $request['answer6'],
      'answer7' => $request['answer7'],
      'answer8' => $request['answer8'],
      'answer9' => $request['answer9'],
      'answer10' => $request['answer5'],
      'answer11' => $request['answer11'],
      'answer12' => $request['answer12'],
      'answer13' => $request['answer13'],
      'answer14' => $request['answer14'],
      'answer15' => $request['answer15'],
      'answer16' => $request['answer16'],
      'answer17' => $request['answer17'],
      'answer18' => $request['answer18'],
      'answer19' => $request['answer19'],
      'answer20' => $request['answer20'],
      'information1' => $request['information1'],
      'information2' => $request['information2'],
      'information3' => $request['information3'],
      'information4' => $request['information4'],
      'information5' => $request['information5'],
      'information6' => $request['information6'],
      'information7' => $request['information7'],
      'information8' => $request['information8'],
      'information9' => $request['information9'],
      'information10' => $request['information10'],
      'information11' => $request['information11'],
      'information12' => $request['information12'],
      'information13' => $request['information13'],
      'information14' => $request['information14'],
      'information15' => $request['information15'],
      'information16' => $request['information16'],
      'information17' => $request['information17'],
      'information18' => $request['information18'],
      'information19' => $request['information19'],
      'information20' => $request['information20'],
      'risk_level' => $risk_level,
      'take_num' => $request['take_num'],
    ]);
  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    //
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, $id)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    $evaluation = Ytt2Evaluation::findOrFail($id);

    $evaluation->delete();

    return ['message' => 'Evaluation Deleted'];
  }
}
