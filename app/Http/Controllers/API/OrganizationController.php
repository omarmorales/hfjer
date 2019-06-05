<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Organization;

class OrganizationController extends Controller
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
    if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
      return Organization::latest()->paginate(200);
    }
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

    return Organization::create([
      'name' => $request['name'],
      'description' => $request['description'],
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
    $organization = Organization::findOrFail($id);

    $this->validate($request,[
      'name' => 'required|string',
      'description' => 'required',
    ]);

    $organization->update($request->all());
    return ['message' => 'Updated the organization info'];


  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    $this->authorize('isAdmin');

    $organization = Organization::findOrFail($id);
    $organization->users()->delete();
    $organization->groups()->delete();
    $organization->delete();

    return ['message' => 'Organization Deleted'];
  }
}
