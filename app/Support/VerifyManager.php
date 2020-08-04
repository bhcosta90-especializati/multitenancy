<?php

namespace App\Support;

class VerifyManager
{
    public static function verify()
    {
        return strpos(config('app.main'), request()->getHost());
    }
}
