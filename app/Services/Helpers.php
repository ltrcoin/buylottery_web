<?php
function locale()
{
    return app()->make(App\Services\Locale::class);
}