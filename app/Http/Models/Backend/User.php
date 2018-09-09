<?php

namespace App\Http\Models\Backend;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullname', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    const STATUS_ACTIVE = 1;
    const STATUS_HIDE = 0;
    const PAGE_SIZE = 10;
    static $STATUS = [
        self::STATUS_ACTIVE => "Hiện",
        self::STATUS_HIDE => "Ẩn"
    ];


    /*public function group_user()
    {
        return $this->belongsTo('App\Http\Models\Backend\GroupUser', 'id', 'user_id');
    }

    public function groups() {
        return $this->belongsToMany(Group::class, 'group_user', 'user_id', 'group_id');
    }

    public function hasAnyRole($roles)
    {
        if(is_array($roles)) {
            foreach ($roles as $role) {
                if($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if($this->hasRole($roles)) {
                    return true;
                }
        }
        return false;
    }
     public function hasRole($role)
     {
        if($this->group_user) {
            $checkPermission = GroupPermission::where('group_id', $this->group_user->group_id)
                                    ->where('permission_id', $role)
                                    ->first();
            if($checkPermission) {
                return true;
            }
        }
        return false;
     }

     public function unreadNotifications() {
        return Notification::where('user_id', $this->id)->where('mark_as_read', 0)->orderBy('created_at', 'desc')->limit(5)->get();
     }*/
}
