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
	        return redirect()->route('frontend.ps.show2faForm')->with('error',"Invalid Verification Code, Please try again. Contact Admin for Support");
	    }
	}


public function h_enable2fa(Request $request) {
	    $user = Customer::find(\Session::get('2fa:isLogged')->id);
		$sc=$request->session()->get('newsc');

	   PasswordSecurity::create([
	        'customer_id' => $user->id,
	        'google2fa_enable' => 0,
	        'google2fa_secret' => $sc,
	    ]);


	    $google2fa = app('pragmarx.google2fa');
	    $secret = $request->input('verify-code');
	    $valid = $google2fa->verifyKey($user->passwordSecurity->google2fa_secret, $secret);
	    if ($valid) {
	        $user->passwordSecurity->google2fa_enable = 1;
	        $user->passwordSecurity->save();
	        //return redirect('2fa')->with('success',"2FA is Enabled Successfully.");
	       
	        return redirect()->route('frontend.ps.2fasetting');
	   
		} else {
	        return redirect()->route('frontend.ps.show2faForm')->with('error',"Invalid Verification Code, Please try again. Contact Admin for Support");
	    }

}


	public function g_enable2fa(Request $request) {
	    $user = Customer::find(\Session::get('2fa:isLogged')->id);
		
	    if (isset($user->passwordSecurity)) { 

			$user->passwordSecurity->google2fa_enable = 1;
	        $user->passwordSecurity->save();
	        return redirect()->route('frontend.ps.2fasetting');
	    }
	   
	    $google2fa = app('pragmarx.google2fa');

	   	$sc=$google2fa->generateSecretKey();
	   	$request->session()->put('newsc',$sc);
	    
	        $google2fa->setAllowInsecureCallToGoogleApis(true);
	        $google2fa_url = $google2fa->getQRCodeGoogleUrl(
	            'Lottery 2FA',
	            $user->email,
				$sc
	            //$user->passwordSecurity->google2fa_secret
	        );
	    
	    $data = [
	        'user' => $user,
	        'google2fa_url' => $google2fa_url
	    ];

    	return view('frontend.auth.g_2fa', $data);
	    
	}

	public function secondfasetting(Request $request) {
	    $user = Customer::find(\Session::get('2fa:isLogged')->id);
		$fastatus='';
	    if (isset($user->passwordSecurity)) { 
	    	if ($user->passwordSecurity->google2fa_enable) {
	    		$fastatus='ON';
	    	} else {
	    		$fastatus='OFF';
	    	}		 
	    } else {
	    	$fastatus='NULL';
	    }

    	return view('frontend.auth.2fasetting', ['status'=>$fastatus]);
	    
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
		    if (isset($user->passwordSecurity)) {
		    	 $user->passwordSecurity->google2fa_enable = 0;
		    	 $user->passwordSecurity->save();
		    }
		   
		    return redirect()->route('frontend.ps.2fasetting');
		}

		$user = Auth::guard('web')->user();
		if (isset($user->passwordSecurity)) { 
			return view('frontend.auth.disable2fa');
		}

		return view('frontend.auth.cannot_disable2fa');
		
	}

 	public function getVerify2fa()
    {
    	$user = Customer::find(\Session::get('2fa:isLogged')->id);
    	/*------on 23 9 2018
    	if (!isset($customer->passwordSecurity) || !$customer->passwordSecurity->google2fa_enable) {

            Auth::guard('web')->loginUsingId($user->id);
        	return redirect('/'); 

    	}
		*/
    	if ($user->passwordSecurity->google2fa_enable) {
            return view('frontend.auth.google2fa');
        } 
    }
	public function verify2fa(Request $request) {
	    $user = Customer::find(\Session::get('2fa:isLogged')->id);
	    $google2fa = app('pragmarx.google2fa');
	    $secret = $request->input('one_time_password');
	    $valid = $google2fa->verifyKey($user->passwordSecurity->google2fa_secret, $secret);
	    if ($valid) {
	    	if (Auth::guard('web')->loginUsingId($user->id)) {
	    		//\Session::forget('2fa:isLogged');
	        	return redirect()->route('frontend.site.index');
	    	} else {
	    		return redirect('verify2fa')->with('error',"Invalid Verification Code, Please try again! Or if you do not have Verification Code on your phone, you can contact Admin for support."); 


	    	}
	    } else {
	        return redirect('verify2fa')->with('error',"Invalid Verification Code, Please try again! Or if you do not have Verification Code on your phone, you can contact Admin for support.");
	        /* There 3 two reason for not having verification on the phone:
	    		 1. Customer generate google2fasecret but do not scan qr code to complete the  enable 2fa process correctly, Admin can delete the current record on password security and lets user try again.
	    		2. Customer lost their phone...admin can delete current record and lets user try again .
	    		
	    		In case 1, 2 customer need to provide more information about their account to prove that he is the owner of the account.  
	    		 3. Hacker try to login user account. 
	    	 	*/
	    }
	}
}
