<?php

use Illuminate\Http\Request;

/*php
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources(['user' => 'API\UserController']);
Route::get('profile', 'API\UserController@profile');
Route::get('findUser', 'API\UserController@search');
Route::put('profile', 'API\UserController@updateProfile');

Route::apiResources(['organization' => 'API\OrganizationController']);

Route::apiResources(['group' => 'API\GroupController']);

Route::apiResources(['beneficiary' => 'API\BeneficiaryController']);
Route::get('beneficiary_by_folio/{folio}', 'API\BeneficiaryController@beneficiarybyfolio');

Route::apiResources(['ytt1evaluation' => 'API\Ytt1EvaluationController']);
Route::get('yttevaluationdate/{id}', 'API\Ytt1EvaluationController@evaluationDate');
Route::get('yttevaluationresult/{id}', 'API\Ytt1EvaluationController@evaluationResult');

Route::apiResources(['ytt1draft' => 'API\Ytt1DraftController']);

Route::apiResources(['ytt2evaluation' => 'API\Ytt2EvaluationController']);

Route::apiResources(['ytt2draft' => 'API\Ytt2DraftController']);
