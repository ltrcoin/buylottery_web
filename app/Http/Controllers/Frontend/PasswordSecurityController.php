<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\FrontendController as Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\Frontend\PasswordSecurity;
use App\Http\Models\Frontend\Customer;

class PasswordSecurityController extends Controller
{
    public function show2faForm(Request $request) {
	    $user = Customer::find(\Session::get('2fa:isLogged')->id);
	    $google2fa_url = "";
	    if(isset($user->passwordSecurity)){
	    	if($user->passwordSecurity->google2fa_enable) {
				return redirect()->route('frontend.ps.verify2fa');
			}
	        $google2fa = app('pragmarx.google2fa');
	        $google2fa->setAllowInsecureCallToGoogleApis(true);
	        $google2fa_url = $google2fa->getQRCodeGoogleUrl(
	            'Lottery 2FA',
	            $user->email,
	            $user->passwordSecurity->google2fa_secret
	        );
	    }
	    $data = [
	        'user' => $user,
	        'google2fa_url' => $google2fa_url
	    ];
    	return view('frontend.auth.2fa', $data);
	}

	public function generate2faSecret(Request $request) {
	    $user = \Session::get('2fa:isLogged');
	    // Initialise the 2FA class
	    $google2fa = app('pragmarx.google2fa');
	    // Add the secret key to the registration data
	    PasswordSecurity::create([
	        'customer_id' => $user->id,
	        'google2fa_enable' => 0,
	        'google2fa_secret' => $google2fa->generateSecretKey(),
	    ]);
	    return redirect()->route('frontend.ps.show2faForm')->with('success',"Secret Key is generated, Please verify Code to Enable 2FA");
	}

	public function enable2fa(Request $request) {
	    $user = Customer::find(\Session::get('2fa:isLogged')->id);
		if($user->passwordSecurity->google2fa_enable) {
			return redirect()->route('frontend.ps.verify2fa');
		}
	    $google2fa = app('pragmarx.google2fa');
	    $secret = $request->input('verify-code');
	    $valid = $google2fa->verifyKey($user->passwordSecurity->google2fa_secret, $secret);
	    if ($valid) {
	        $user->passwordSecurity->google2fa_enable = 1;
	        $user->passwordSecurity->save();
	        //return redirect('2fa')->with('success',"2FA is Enabled Successfully.");
	        if (Auth::guard('web')->loginUsingId($user->id)) {
	    		\Session::forget('2fa:isLogged');
	        	return redirect()->route('frontend.site.index');
	    	} else {
	    		return redirect('verify2fa')->with('error',"Invalid Verification Code, Please try again.");	
	    	}
	        return redirect('/');
	    } else {
	        return redirect()->route('frontend.ps.show2faForm')->with('error',"Invalid Verification Code, Please try again.");
	    }
	}

	public function disable2fa(Request $request) {
		if ($request->isMethod('post')) {
		    if (!(\Hash::check($request->get('current-password'), Auth::guard('web')->user()->password))) {
		        // The passwords matches
		        return redirect()->back()->with("error","Your  password does not matches with your account password. Please try again.");
		    }

		    \Validator::make($request->all(), [
	        	'current-password' => 'required',
		    ])->validate();
		    $user = Auth::guard('web')->user();
		    $user->passwordSecurity->google2fa_enable = 0;
		    $user->passwordSecurity->save();
		    return redirect()->route('frontend.ps.show2faForm')->with('success',"2FA is now Disabled.");
		}
		return view('frontend.auth.disable2fa');
	}

 	public function getVerify2fa()
    {
    	$user = Customer::find(\Session::get('2fa:isLogged')->id);
    	if ($user->passwordSecurity->google2fa_enable) {
            return view('frontend.auth.google2fa');
        } else {
        	return redirect()->route('frontend.ps.show2faForm');
        	//return redirect('/');
        }
    }
	public function verify2fa(Request $request) {
	    $user = Customer::find(\Session::get('2fa:isLogged')->id);
	    $google2fa = app('pragmarx.google2fa');
	    $secret = $request->input('one_time_password');
	    $valid = $google2fa->verifyKey($user->passwordSecurity->google2fa_secret, $secret);
	    if ($valid) {
	    	if (Auth::guard('web')->loginUsingId($user->id)) {
	    		\Session::forget('2fa:isLogged');
	        	return redirect()->route('frontend.site.index');
	    	} else {
	    		return redirect('verify2fa')->with('error',"Invalid Verification Code, Please try again.");	
	    	}
	    } else {
	        return redirect('verify2fa')->with('error',"Invalid Verification Code, Please try again.");
	    }
	}
}
