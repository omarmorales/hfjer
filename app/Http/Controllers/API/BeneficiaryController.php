<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Beneficiary;

class BeneficiaryController extends Controller
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
    return Beneficiary::with('ytt1_evaluations')->with('ytt1_draft')->with('ytt2_evaluations')->with('ytt2_draft')->with('group')->latest()->get();
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
      'name' => 'required|string',
      'lastname_one' => 'required|string',
      'lastname_two' => 'required|string',
      'gender' => 'required',
    ]);

    return Beneficiary::create([
      'lastname_one' => $request['lastname_one'],
      'lastname_two' => $request['lastname_two'],
      'name' => $request['name'],
      'birthdate' => $request['birthdate'],
      'gender' => $request['gender'],
      'folio' => $request['folio'],
      'group_id' => $request['group_id'],
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
    return Beneficiary::with('ytt1_evaluations')->with('ytt1_draft')->with('ytt2_evaluations')->with('ytt2_draft')->with('group')->find($id);
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
    $beneficiary = Beneficiary::findOrFail($id);

    $this->validate($request,[
      'name' => 'required|string',
    ]);

    $beneficiary->update($request->all());
    return ['message' => 'Updated the beneficiary info'];
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    $beneficiary = Beneficiary::findOrFail($id);
    $beneficiary->delete();
    return ['message' => 'Beneficiary Deleted'];
  }

  public function beneficiarybyfolio($folio)
  {
    $beneficiarySelected = Beneficiary::with('ytt1_evaluations')->with('ytt1_draft')->with('ytt2_evaluations')->with('ytt2_draft')->with('group')->where('folio', $folio)->first();
    if (!$beneficiarySelected)
            return abort(404);
    return $beneficiarySelected;
  }
}
