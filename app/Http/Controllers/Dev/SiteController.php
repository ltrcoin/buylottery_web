<?php

namespace App\Http\Controllers\Dev;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\Dev\Dev;

class SiteController extends Controller
{
    public function login(Request $request) 
    {
    	if($request->isMethod("post")) {
    		/*validate data request*/
            Validator::make($request->all(), [
                'password' => 'required',
                'email' => 'required|email'              
            ])->validate();

            $user['email'] = $request->email;
            $user['password'] = $request->password;
            $remember_token = ($request->remember_token != null) ? true : false;
            if(Auth::guard('dev')->attempt($user, $remember_token)) {
            	return redirect()->route('dev.site.index');
            } else {
            	return redirect()->route('dev.site.vLogin')->withErrors("Email or password incorect!");
            }
    	}
    	return view('dev.site.login');
    }

    public function index() 
    {
    	return redirect()->route('dev.permission.index');
    }

    public function error() 
    {
    	return view('dev.site.error');
    }

    public function logout()
    {
    	Auth::guard('dev')->logout();
        return redirect()->route('dev.site.vLogin');
    }
}
