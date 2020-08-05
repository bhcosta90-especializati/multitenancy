<?php

namespace App\Support;

class VerifyManager
{
    public static function verify(): bool
    {
        return (bool)strpos(config('tenant.main'), request()->getHost());
    }
}
