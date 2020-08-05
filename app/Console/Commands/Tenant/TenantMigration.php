<?php

namespace App\Console\Commands\Tenant;

use App\Jobs\Tenant\Migrate;
use App\Models\Company;
use App\Tenant\ManagerTenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class TenantMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:migrate {id?} {--refresh}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run migrations tenants';
    private $tenant;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ManagerTenant $tenant)
    {
        parent::__construct();
        $this->tenant = $tenant;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tenant = $this->argument('id');
        $refresh = $this->option('refresh');

        $command = "migrate";

        if ($refresh) {
            $command = "migrate:refresh";
        }

        if ($tenant) {
            $companies = Company::whereId($tenant)->get();
        } else {
            $companies = Company::orderBy('created_at')->get();
        }

        foreach ($companies as $company) {
            $this->info("Company: {$company->name} ($company->id)");
            $parameters = [
                '--database' => 'tenant',
                '--force' => true,
                '--path' => '/database/migrations/tenant',
            ];

            $this->info("Init command {$command}");
            $this->tenant->setConnection($company);
            $migrate = Artisan::call($command, $parameters);
            $this->info("Finish command {$command}");
            $this->info("Result: {$migrate}");
            $this->info("---------------------------------------------------------------------");
        }
    }
}
