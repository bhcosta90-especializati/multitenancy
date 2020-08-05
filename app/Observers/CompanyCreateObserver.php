<?php

namespace App\Observers;

use App\Jobs\Tenant\CreateDatabase;
use App\Models\Company;

class CompanyCreateObserver
{
    public function creating(Company $obj){
        $obj->bd_database = "multitenant_" . sha1($obj->id);
        $obj->bd_username_read = "tenant_read";
        $obj->bd_username_write = "tenant_write";

        $obj->bd_password_read = "t1e2n3a4nt_read";
        $obj->bd_password_write = "t1e2n3a4nt_write";
    }

    public function created(Company $obj)
    {
        CreateDatabase::dispatch($obj);
    }
}
