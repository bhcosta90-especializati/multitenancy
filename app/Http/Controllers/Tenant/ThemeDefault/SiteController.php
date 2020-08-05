<?php

namespace App\Http\Controllers\Tenant\ThemeDefault;

use App\Http\Controllers\Main\Controller;

class SiteController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        return view('tenant.theme-default.welcome');
    }
}
