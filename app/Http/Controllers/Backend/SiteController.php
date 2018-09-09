<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Models\Backend\User;
use Loc;

class SiteController extends Controller
{
    public function login(Request $request) 
    {
        if($request->isMethod("post")) {
            /*validate data request*/
            Validator::make($request->all(), [
                'password' => 'required',
                'email' => 'required'              
            ])->validate();
            $user = [
                'email' => $request->email,
                'password' => $request->password,
                'status' => User::STATUS_ACTIVE
            ];
            $remember_token = ($request->remember_token != null) ? true : false;
            if(Auth::guard('admin')->attempt($user, $remember_token)) {
                return redirect()->route('backend.site.index');
            } else {
                return redirect()->route('backend.site.vLogin')->withErrors(__('messages.login_fail'));
            }
        }
        return view('backend.site.login');
    }

    public function index() 
    {
        return redirect()->route('backend.user.profile');
    }

    public function error($errorCode, $msg) 
    {
        return view('backend.site.error', ['errorCode'=>$errorCode, 'msg'=>$msg]);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('backend.site.vLogin');
    }

    public function resetPass(Request $request)
    {
        if($request->isMethod("post")) {

        }
        return view('backend.site.resetPass');
    }

    public function uploadImageContent(Request $request)
    {
        if($request->isMethod("post")) {
            if ($request->hasFile('file')) {
                /*upload file to public/upload/content*/
                $path = $request->file('file')->store(
                    'content/'.date("Y",time()).'/'.date("m",time()).'/'.date("d",time()), 'upload'
                );
                /*if(file_exists($product->introimage)) {
                    unlink($product->introimage);
                }*/
                return response()->json(asset('upload/'.$path));
            }
        }
    }

    public function changeLanguage(Request $request){
        try{
            $lang = !is_null($request->input('lang')) ? $request->input('lang') : 'vi';
            \Session::put('locale', $lang);
            App::setLocale($lang);
        }catch(Exception $e){

        }
    }
}
