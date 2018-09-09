<?php 
namespace App\Services;

use Laravel\Socialite\Contracts\User as ProviderUser;
use App\Http\Models\Backend\SocialAccount;
use App\Http\Models\Backend\User;

class SocialAccountService
{
    public static function createOrGetUser(ProviderUser $providerUser, $social)
    {
        $account = SocialAccount::whereProvider($social)
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        } else {
            $email = $providerUser->getEmail() ?? $providerUser->getNickname();
            $user = User::whereEmail($email)->first();

            if (!$user) {
                try {
                    \DB::beginTransaction();
                    $user = new User();
                    $user->email = $email;
                    $user->fullname = $providerUser->getName();
                    $user->password = bcrypt($providerUser->getId());
                    $user->introimage = $providerUser->getAvatar();
                    $user->status = 1;
                    $user->is_admin = 2;
                    $user->created_at = date('Y-m-d H:i:s');
                    $user->updated_at = date('Y-m-d H:i:s');
                    if($user->save()) {
                        $account = new SocialAccount();
                        $account->provider_user_id = $providerUser->getId();
                        $account->provider = $social;
                        $account->user_id = $user->id;
                        $account->save();
                    }
                    \DB::commit();
                } catch(Exception $e) {
                    \DB::rollback();
                }
            }

            return $user;
        }
    }
}