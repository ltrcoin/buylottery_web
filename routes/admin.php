<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::group(['middleware'=>'guest'],
	function() {
		Route::get('/', [
			'as' => 'backend.site.vLogin',
			'uses'  => 'SiteController@login'
			]);

		Route::get('/login', [
			'as' => 'backend.site.vLogin',
			'uses'  => 'SiteController@login'
			]);

		Route::post('/login', [
			'as' => 'backend.site.pLogin',
			'uses'  => 'SiteController@login'
			]);

		Route::post('resetPass', [
			'as' => 'backend.site.vResetPass',
			'uses'  => 'SiteController@resetPass'
			]);
		Route::post('resetPass', [
			'as' => 'backend.site.pResetPass',
			'uses'  => 'SiteController@resetPass'
			]);
		Route::get('redirect/{socical}', [
			'as' => 'backend.site.socicalRedirect',
			'uses' => 'SocialAuthController@redirect'
		]);

	    Route::get('callback/{social}', [
	    	'as' => 'backend.site.socialCallback',
	    	'uses' => 'SocialAuthController@callback'
	    ]);
	    Route::get('dieukhoandichvu', function() {
	    	return \View::make('backend.site.dieukhoandichvu');
	    });
		Route::get('chinhsachbaomat', function() {
	    	return \View::make('backend.site.chinhsachbaomat');
	    });
	}
);

Route::group(['middleware'=>['auth' , 'setLocale']],
	function() {
		/*SiteController*/
		Route::get('/home', [
			'as' => 'backend.site.index',
			'uses'  => 'SiteController@index',
			'roles' => ['backend.site.index']
			]);
		Route::get('/logout', [
			'as' => 'backend.site.logout',
			'uses'  => 'SiteController@logout',
			'roles' => ['backend.site.logout']
			]);
		Route::get('/site/error/{errorCode}-{msg}', [
			'as' => 'backend.site.error',
			'uses'  => 'SiteController@error',
			'roles' => ['backend.site.error']
			]);
		Route::post('site/uploadImageContent', [
			'as' => 'backend.site.uploadImageContent',
			'uses'  => 'SiteController@uploadImageContent',
			'roles' => ['backend.site.uploadImageContent']
			]);
		Route::get('/config/language', [
			'as' => 'backend.config.language',
			'uses'  => 'SiteController@changeLanguage',
			'roles' => ['backend.config.language']
		]);
		Route::get('user/profile', [
			'as' => 'backend.user.profile',
			'uses'  => 'UserController@profile',
			'roles' => ['backend.user.profile']
			]);
		Route::post('user/profile', [
			'as' => 'backend.user.pProfile',
			'uses'  => 'UserController@profile',
			'roles' => ['backend.user.profile']
			]);
		Route::post('user/changePass', [
			'as' => 'backend.user.pChangePass',
			'uses'  => 'UserController@changePass',
			'roles' => ['backend.user.profile']
			]);
		Route::get('site/huong-dan', function() {
			return \View::make('backend.site.help');
		});
	}
);

Route::group(['middleware'=>['auth','setLocale']],
	function() {

		/*UserController*/
        Route::get('user/indexData', [
            'as' => 'backend.user._indexAjaxData',
            'uses' => 'UserController@_indexAjaxData',
            'roles' => ['backend.user.index']
        ]);
		Route::get('user/index', [
			'as' => 'backend.user.index',
			'uses'  => 'UserController@index',
			'roles' => ['backend.user.index']
			]);
		Route::get('user/add', [
			'as' => 'backend.user.vAdd',
			'uses'  => 'UserController@add',
			'roles' => ['backend.user.add']
			]);
		Route::post('user/add', [
			'as' => 'backend.user.pAdd',
			'uses'  => 'UserController@add',
			'roles' => ['backend.user.add']
			]);
		Route::get('user/edit/{id}', [
			'as' => 'backend.user.vEdit',
			'uses'  => 'UserController@edit',
			'roles' => ['backend.user.edit']
			]);
		Route::post('user/edit/{id}', [
			'as' => 'backend.user.pEdit',
			'uses'  => 'UserController@edit',
			'roles' => ['backend.user.edit']
			]);
		Route::get('user/delete/{id}', [
			'as' => 'backend.user.delete',
			'uses'  => 'UserController@delete',
			'roles' => ['backend.user.delete']
			]);
		Route::post('user/reverseStatus', [
			'as' => 'backend.user.reverseStatus',
			'uses'  => 'UserController@reverseStatus',
			'roles' => ['backend.user.edit']
			]);	

		Route::group(['prefix' => 'game', 'as' => 'backend.game.'], function() {
			Route::get('index', [
				'as' => 'index',
				'uses' => 'GameController@index',
				'roles' => ['backend.game.index']
			]);
			Route::get('indexData', [
				'as' => '_indexAjaxData',
				'uses' => 'GameController@_indexAjaxData',
				'roles' => ['backend.game.index']
			]);
			Route::get('add', [
				'as' => 'vAdd',
				'uses' => 'GameController@add',
				'roles' => ['backend.game.add']
			]);
			Route::post('add', [
				'as' => 'pAdd',
				'uses' => 'GameController@pAdd',
				'roles' => ['backend.game.add']
			]);
			Route::get('edit/{id}', [
				'as' => 'vEdit',
				'uses' => 'GameController@edit',
				'roles' => ['backend.game.edit']
			]);
			Route::post('edit/{id}', [
				'as' => 'pEdit',
				'uses' => 'GameController@pAdd',
				'roles' => ['backend.game.edit']
			]);
			Route::get('detail/{id}', [
				'as' => 'detail',
				'uses'  => 'GameController@detail',
				'roles' => ['backend.game.detail']
			]);
			Route::get('delete/{id}', [
				'as' => 'delete',
				'uses'  => 'GameController@delete',
				'roles' => ['backend.game.delete']
			]);
			Route::get('draw-result/{id}', [
				'as' => 'delete',
				'uses'  => 'GameController@drawResult',
				'roles' => ['backend.game.add']
			]);
			Route::get('update-result-game/{id}', [
				'as' => 'updateResultGame',
				'uses'  => 'GameController@updateResultGame',
				'roles' => ['backend.game.add']
			]);
		});

		Route::group(['prefix' => 'media', 'as' => 'backend.media.'], function() {
			Route::post( 'image', 'MediaController@image' )->name( 'uploadImage' );
			Route::post( 'image-crop', 'MediaController@imageCrop' )->name( 'cropImage' );
		});

		Route::group(['prefix' => 'ticket', 'as' => 'backend.ticket.'], function() {
			Route::get( 'index', [
				'as'    => 'index',
				'uses'  => 'TicketController@index',
				'roles' => [ 'backend.ticket.index' ]
			] );
			Route::get( 'indexData', [
				'as'    => '_indexAjaxData',
				'uses'  => 'TicketController@_indexAjaxData',
				'roles' => [ 'backend.ticket.index' ]
			] );
		});

        Route::group(['prefix' => 'customer', 'as' => 'backend.customer.'], function() {
            Route::get( 'index', [
                'as'    => 'index',
                'uses'  => 'CustomerController@index',
                'roles' => [ 'backend.customer.index' ]
            ] );
            Route::get( 'indexData', [
                'as'    => '_indexAjaxData',
                'uses'  => 'CustomerController@_indexAjaxData',
                'roles' => [ 'backend.customer.index' ]
            ] );
	        Route::get( 'delete/{id}', [
		        'as'    => 'delete',
		        'uses'  => 'CustomerController@delete',
		        'roles' => [ 'backend.customer.delete' ]
	        ] );
            Route::post('reverse-status', [
            	'as' => 'reverseStatus',
	            'uses' => 'CustomerController@reverseStatus',
	            'roles' => [ 'backend.customer.index' ],
            ]);
        });
	}
);