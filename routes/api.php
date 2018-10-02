<?php


use Illuminate\Http\Request;

/*
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

Route::post('/getbalance', [
            'as' => 'frontend.api.getbalance',
            'uses'  => 'APISiteController@getbalance'
        ]);
Route::post('/buytickets', [
            'as' => 'frontend.api.buytickets',
            'uses'  => 'APISiteController@buytickets'
        ]);
Route::get('/gamesinfo', [
            'as' => 'frontend.api.gamesinfo',
            'uses'  => 'APISiteController@gamesinfo'
        ]);

Route::get('/winningnumbers', [
            'as' => 'frontend.api.winningnumbers',
            'uses'  => 'APISiteController@winningnumbersapi'
        ]);

Route::post('/login', [
			'as' => 'frontend.api.login',
			'uses'  => 'APISiteController@apilogin'
		]);

Route::get('/login', function (Request $request) {
    return response()->json([
    		'status'=>422,
    		'msg'=>'Get method refused',
    		'data'=>[]
    		]);
});
	
Route::post('/validateregister', [
            'as' => 'frontend.api.validateregister',
            'uses'  => 'APISiteController@validateregister'
        ]);

Route::post('/register', [
            'as' => 'frontend.api.register',
            'uses'  => 'APISiteController@apiregister'
        ]);

Route::get('/register', function (Request $request) {
    return response()->json([
            'status'=>422,
            'msg'=>'Get method refused',
            'data'=>[]
            ]);
});
    
            