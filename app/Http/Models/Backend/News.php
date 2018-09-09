<?php

namespace App\Http\Models\Backend;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
	use SoftDeletes;
    protected $table = 'news';

    public $timestamps = true;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    const STATUS_HIDE = 0;
    const STATUS_ACTIVE = 1;
    const PAGE_SIZE = 10;

    static $STATUS = [
    	self::STATUS_ACTIVE => "Hiện",
    	self::STATUS_HIDE => "Ẩn"
    ];
}
