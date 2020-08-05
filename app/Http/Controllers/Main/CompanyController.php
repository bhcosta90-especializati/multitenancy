<?php

namespace App\Http\Controllers\Main;

use App\Http\Requests\Main\CompanyRequest;
use App\Jobs\Tenant\CreateDatabase;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    public function store(CompanyRequest $request)
    {
        $data = $request->validated();

        $data += [
            "domain" => $data['slug'],
            "bd_hostname" => "localhost",
        ];

        Company::create($data);
    }
}
