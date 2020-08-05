<?php


namespace App\Tenant\Database;


use App\Models\Company;
use Illuminate\Support\Facades\DB;

class DatabaseManager
{
    public static function dropDatabase(Company $company)
    {
        DB::statement("
            DROP DATABASE IF EXISTS {$company->bd_database}
        ");
    }

    public static function createDatabase(Company $company)
    {
        DB::statement("
            CREATE DATABASE IF NOT EXISTS {$company->bd_database} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
        ");
    }

    public static function createUser(Company $company)
    {
        DB::statement("
            CREATE USER 'tenant_read'@'{$company->bd_hostname}' IDENTIFIED BY 't1e2n3a4nt_read';
        ");

        DB::statement("
            CREATE USER 'tenant_write'@'{$company->bd_hostname}' IDENTIFIED BY 't1e2n3a4nt_write';
        ");
    }

    public static function previlegiesUser(Company $company)
    {
        DB::statement("
            GRANT SELECT ON {$company->bd_database}.* TO tenant_read@'{$company->bd_hostname}';
        ");

        DB::statement("
            GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, ALTER, DROP ON {$company->bd_database}.* TO tenant_write@'{$company->bd_hostname}';
        ");
    }
}
