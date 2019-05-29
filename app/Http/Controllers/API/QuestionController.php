<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Question;
use Illuminate\Support\Facades\Mail;
use App\Mail\QuestionMail;

class QuestionController extends Controller
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
        //
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
            'title' => 'required|string',
            'description' => 'required',
            'user_id' => 'required',
        ]);

        $user = auth('api')->user();
        $title = $request['title'];
        $description = $request['description'];
        $toEmail = "saul090594@gmail.com";

        Mail::to($toEmail)->send(new QuestionMail($user, $title, $description));
    
        return Question::create([
            'title' => $request['title'],
            'description' => $request['description'],
            'user_id' => $request['user_id'],
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
        //
    }
}
