<?php

namespace App\Tenant;

use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ManagerTenant
{
    public function setConnection(Company $company)
    {
        DB::purge('tenant');

        config()->set('database.connections.tenant.driver', $company->bd_driver);
        config()->set('database.connections.tenant.host', $company->bd_hostname);
        config()->set('database.connections.tenant.port', $company->bd_port);
        config()->set('database.connections.tenant.database', $company->bd_database);
        config()->set('database.connections.tenant.username', $company->bd_username);
        config()->set('database.connections.tenant.password', $company->bd_password);

        DB::reconnect('tenant');

        Schema::connection('tenant')->getConnection()->reconnect();

        return $this;
    }

    public function setView(Company $company){
        config()->set('view.paths', [resource_path("views/tenant/{$company->theme}")]);
        config()->set('view.compiled', env('VIEW_COMPILED_PATH', realpath(storage_path("framework/views"))) . "/tenant/{$company->theme}");

        return $this;
    }
}
