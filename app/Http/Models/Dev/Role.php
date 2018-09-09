<?php

namespace App\Http\Models\Dev;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = "roles";

    const PAGE_SIZE = 10;
}
