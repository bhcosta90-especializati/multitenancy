<?php

namespace App\Http\Controllers\Main;

use App\Http\Requests\Main\CompanyRequest;
use App\Models\Company;

class SiteController extends Controller
{
    public function index(Company $company)
    {
        return view("main.welcome");
    }

    public function migrate()
    {
        return view("main.migrate");
    }

    public function companyStore(CompanyRequest $companyRequest)
    {
        if (empty(env('DB_HOST_TENANT'))) {
            throw new \Exception('Favor informar `DB_HOST_TENANT`');
        }


        $data = $companyRequest->validated();
        $obj = Company::create($data + [
                "document" => $data['document'],
                "domain" => $data['slug'],
                "bd_hostname" => env('DB_HOST_TENANT')
            ]);
        $ret = __('Loja registrada com sucesso em nossa base de dados, aguardar alguns instantes para acessar');
        $ret .= " <b><a href='http://{$obj->domain}' target='_blank'>{$obj->domain}</a></b>";

        return $ret;
    }
}
