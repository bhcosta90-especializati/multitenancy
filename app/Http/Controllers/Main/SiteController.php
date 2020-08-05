<?php

namespace App\Http\Controllers\Main;

use App\Http\Requests\Main\CompanyRequest;
use App\Jobs\Tenant\CreateDatabase;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiteController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
}
