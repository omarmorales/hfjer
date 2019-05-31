<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCreatedMail;
use App\Mail\UserUpdatedMail;


class UserController extends Controller
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
    // $this->authorize('isAdmin');
    if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
      return User::with('organization')->latest()->paginate(100);
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
      'name' => 'required|string|max:191',
      'email' => 'required|string|email|max:191|unique:users',
      'password' => 'required|string|min:6'
    ]);

    $name = $request['name'];
    $email = $request['email'];
    $password = $request['password'];

    Mail::to($email)->send(new UserCreatedMail($name, $email, $password));

    return User::create([
      'name' => $request['name'],
      'email' => $request['email'],
      'type' => $request['type'],
      'bio' => $request['bio'],
      'photo' => $request['photo'],
      'password' => Hash::make($request['password']),
      'organization_id' => $request['organization_id'],
    ]);


  }


  public function updateProfile(Request $request)
  {
    $user = auth('api')->user();


    $this->validate($request,[
      'name' => 'required|string|max:191',
      'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
      'password' => 'sometimes|required|min:6'
    ]);


    $currentPhoto = $user->photo;


    if($request->photo != $currentPhoto){
      $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];

      \Image::make($request->photo)->save(public_path('img/profile/').$name);
      $request->merge(['photo' => $name]);

      $userPhoto = public_path('img/profile/').$currentPhoto;
      if(file_exists($userPhoto)){
        @unlink($userPhoto);
      }

    }


    if(!empty($request->password)){
      $name_updated = $request['name'];
      $email_updated = $request['email'];
      $password_updated = $request['password'];

      Mail::to($email_updated)->send(new UserUpdatedMail($name_updated, $email_updated, $password_updated));
      
      $request->merge(['password' => Hash::make($request['password'])]);
    }

    $user->update($request->all());
    return ['message' => "Success"];
  }


  public function profile()
  {
    return auth('api')->user();
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

    $user = User::findOrFail($id);

    $this->validate($request,[
      'name' => 'required|string|max:191',
      'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
      'password' => 'sometimes|min:6'
    ]);

    if(!empty($request->password)){
      $request->merge(['password' => Hash::make($request['password'])]);
    }

    $user->update($request->all());
    return ['message' => 'Updated the user info'];
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

    $user = User::findOrFail($id);
    // delete the user

    $user->delete();

    return ['message' => 'User Deleted'];
  }

  public function search(){

    if ($search = \Request::get('q')) {
      $users = User::where(function($query) use ($search){
        $query->where('name','LIKE',"%$search%")
        ->orWhere('email','LIKE',"%$search%");
      })->paginate(20);
    }else{
      $users = User::latest()->paginate(5);
    }

    return $users;

  }
}
