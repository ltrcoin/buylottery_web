<?php

namespace App\Http\Models\Backend;


use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    protected $table = "social_account";
    public $timestamps = true;

    protected $fillable = ['user_id', 'provider_user_id', 'provider'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}