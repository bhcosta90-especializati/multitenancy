<?php

namespace App\Http\Controllers\Main;

use App\Http\Requests\Main\CompanyRequest;
use App\Models\Company;

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
