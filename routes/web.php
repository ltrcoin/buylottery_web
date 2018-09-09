<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*SITE*/
Route::get('/error.html', [
	'as' => 'frontend.site.error',
	'uses'  => 'SiteController@error'
	]);
Route::group(['middleware'=>'guest.web'],
	function() {
		Route::get('/login', [
			'as' => 'frontend.site.vLogin',
			'uses'  => 'SiteController@login'
		]);
		Route::post('/login', [
			'as' => 'frontend.site.pLogin',
			'uses'  => 'SiteController@login'
		]);		
	
		Route::get('/register', [
			'as' => 'frontend.site.vRegister',
			'uses'  => 'SiteController@register'
		]);
		Route::post('/validateRegister', [
			'as' => 'frontend.site.validateRegister',
			'uses'  => 'SiteController@validateAjax'
		]);
		Route::post('/post-register', [
			'as' => 'frontend.site.pRegister',
			'uses'  => 'SiteController@register'
		]);
		Route::get('/login-use-another-account', [
			'as' => 'frontend.site.vUseanotheraccount',
			'uses'  => 'SiteController@login'
		]);
	}
);

Route::group(['middleware'=>'guest.2fa'],
	function() {
		Route::get('/2fa', [
			'as' => 'frontend.ps.show2faForm',
			'uses' => 'PasswordSecurityController@show2faForm'
		]);
		Route::post('/generate2faSecret', [
			'as' => 'frontend.ps.generate2faSecret',
			'uses' => 'PasswordSecurityController@generate2faSecret'
		]);
		Route::post('/p2fa', [
			'as' => 'frontend.ps.enable2fa',
			'uses' => 'PasswordSecurityController@enable2fa'
		]);
		/*Route::post('/disable2fa', [
			'as' => 'frontend.ps.disable2fa',
			'uses' => 'PasswordSecurityController@disable2fa'
		]);*/
		Route::get('/verify2fa', [
			'as' => 'frontend.ps.verify2fa',
			'uses' => 'PasswordSecurityController@getVerify2fa'
		]);
		Route::post('/pverify2fa', [
			'as' => 'frontend.ps.pverify2fa',
			'uses' => 'PasswordSecurityController@verify2fa'
		]);		
	}
);

Route::group(['middleware'=>['auth.web', '2fa']],
	function() {
		Route::get('/disable2fa', [
			'as' => 'frontend.ps.disable2fa',
			'uses' => 'PasswordSecurityController@disable2fa'
		]);
		Route::post('/pdisable2fa', [
			'as' => 'frontend.ps.pdisable2fa',
			'uses' => 'PasswordSecurityController@disable2fa'
		]);
		Route::get('/logout', [
			'as' => 'frontend.site.logout',
			'uses' => 'SiteController@logout'
		]);

		//AccountController
		Route::get('transaction', [
			'as' => 'frontend.account.transaction',
			'uses' => 'AccountController@transaction'
		]);
		Route::get('win', [
			'as' => 'frontend.account.win',
			'uses' => 'AccountController@win'
		]);
		Route::get('profile', [
			'as' => 'frontend.account.profile',
			'uses' => 'AccountController@profile'
		]);
		Route::post('pProfile', [
			'as' => 'frontend.account.pProfile',
			'uses' => 'AccountController@profile'
		]);

		Route::get('/game/cart', [
			'as' => 'frontend.game.cart',
			'uses' => 'GameController@cart'
		]);

		Route::post('/game/checkout', [
			'as' => 'frontend.game.checkout',
			'uses' => 'GameController@checkout'
		]);

		Route::post('/game/checkout-submit', [
			'as' => 'frontend.game.checkoutSubmit',
			'uses' => 'GameController@checkoutSubmit'
		]);
	}
);

Route::get('/', [
	'as' => 'frontend.site.index',
	'uses'  => 'SiteController@index'
]);

Route::get('/game/play/{alias}', [
	'as' => 'frontend.game.play',
	'uses' => 'GameController@play'
]);

Route::post('/game/play/{alias}', [
	'as' => 'frontend.game.submitTicket',
	'uses' => 'GameController@submitTicket'
]);

Route::get('/our-winners', [
	'as' => 'frontend.winner.index',
	'uses' => 'WinnerController@index'
]);

Route::get('/winner-detail/{id}', [
	'as' => 'frontend.winner.detail',
	'uses' => 'WinnerController@detail'
]);

Route::get('/winning-numbers', [
	'as' => 'frontend.winning.index',
	'uses' => 'WinningController@index'
]);

