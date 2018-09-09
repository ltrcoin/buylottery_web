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



Route::post('/login', [
			'as' => 'frontend.site.vapiLogin',
			'uses'  => 'APISiteController@apilogin'
		]);

Route::get('/login', function (Request $request) {
    return response()->json([
    		'status'=>422,
    		'msg'=>'Get method refused',
    		'data'=>[]
    		]);
});
	
			