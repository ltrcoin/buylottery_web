<?php

namespace App\Http\Models\Dev;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'setting';

    public $timestamps = true;

    const INFORMATION = 1;
    const SEO = 2;
    const PAGE_SIZE = 10;

    static $TYPE = [
    	self::INFORMATION => "Liên hệ",
    	self::SEO => "SEO"
    ];
}
