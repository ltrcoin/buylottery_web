<?php

namespace App\Http\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    protected $table   = 'form_field';
    public $timestamps = false;
    static $fieldTypeVi = [
        'Text'       => 'Ký tự',
        'Number'     => 'Số',
        'Date'       => 'Ngày',
        'Date Time'  => 'Ngày Giờ',
        'Text Area'  => 'Văn Bản',
    ];
    static $fieldTypeEn = [
        'Text'       => 'Text',
        'Number'     => 'Number',
        'Date'       => 'Date',
        'Date Time'  => 'Date Time',
        'Text Area'  => 'Text Area',
    ];
}
