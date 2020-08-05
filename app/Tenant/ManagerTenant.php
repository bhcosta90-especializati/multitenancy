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

        config()->set('database.default', 'tenant');
        config()->set('database.connections.tenant.driver', $company->bd_driver);
        config()->set('database.connections.tenant.host', $company->bd_hostname);
        config()->set('database.connections.tenant.port', $company->bd_port);
        config()->set('database.connections.tenant.database', $company->bd_database);
        config()->set('database.connections.tenant.write.username', $company->bd_username_write);
        config()->set('database.connections.tenant.write.password', $company->bd_password_write);
        config()->set('database.connections.tenant.read.username', $company->bd_username_read);
        config()->set('database.connections.tenant.read.password', $company->bd_password_read);

        DB::reconnect('tenant');

        Schema::connection('tenant')->getConnection()->reconnect();

        return $this;
    }
}
