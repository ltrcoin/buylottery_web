<?php
 
namespace App\Facades;
 
use App\Services\Locale;
use Illuminate\Support\Facades\Facade;
 
class MLocale extends Facade
{
    /**
    * Get the registered name of the component.
    *
    * @return string
    */
    protected static function getFacadeAccessor() { return Locale::class; }
}