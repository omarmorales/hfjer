<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Group;

class GroupController extends Controller
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
    return Group::with('user')->latest()->get();
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
      'description' => 'required',
    ]);

    return Group::create([
      'name' => $request['name'],
      'description' => $request['description'],
      'user_id' => $request['user_id'],
      'evaluation' => $request['evaluation'],
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
    return Group::with('beneficiaries')->with('user')->find($id);
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
    $group = Group::findOrFail($id);

    $this->validate($request,[
      'name' => 'required|string',
      'description' => 'required',
    ]);

    $group->update($request->all());
    return ['message' => 'Updated the group info'];
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    $group = Group::findOrFail($id);

    $group->delete();

    return ['message' => 'Group Deleted'];
  }

  public function export_pdf($id)
  {
    $group = Group::find($id);
    $pdf = PDF::loadView('pdf.invoice', compact('group'));
    return $pdf->download('details.pdf');
  }
}
