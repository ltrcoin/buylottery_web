<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SocialAccountService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\Backend\Group;
use App\Http\Models\Backend\GroupUser;
use Socialite;

class SocialAuthController extends Controller
{
    public function redirect($social)
    {
        return Socialite::driver($social)->redirect();
    }

    public function callback($social)
    {
        $user = SocialAccountService::createOrGetUser(Socialite::driver($social)->user(), $social);
        if($user && Auth::loginUsingId($user->id)) {
            return redirect()->route('backend.site.index');
        } else {
            return redirect()->route('backend.site.vLogin');
        }
    }
}
