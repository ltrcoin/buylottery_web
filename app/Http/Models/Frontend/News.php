<?php

namespace App\Http\Models\Frontend;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';

    public $timestamps = true;

    const STATUS_HIDE = 0;
    const STATUS_ACTIVE = 1;
    const PAGE_SIZE = 10;

    static $STATUS = [
    	self::STATUS_ACTIVE => "Hiện",
    	self::STATUS_HIDE => "Ẩn"
    ];
}
