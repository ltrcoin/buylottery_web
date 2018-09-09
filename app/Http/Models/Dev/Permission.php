<?php

namespace App\Http\Models\Dev;

use Illuminate\Database\Eloquent\Model;

class RoleItem extends Model
{
    protected $table = "role_item";

    public $timestamps = false;
    const PAGE_SIZE = 10;
}
