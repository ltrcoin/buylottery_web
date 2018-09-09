<?php

namespace App\Http\Models\Frontend;

use Illuminate\Database\Eloquent\Model;

class PasswordSecurity extends Model
{
    protected $table = 'password_securities';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(Customer::class);
    }
}
