<?php

namespace App\Console\Commands\Tenant;

use App\Jobs\Tenant\DropTenant;
use App\Models\Company;
use App\Tenant\ManagerTenant;
use Illuminate\Console\Command;

class TenantDrop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:drop {id?}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
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

        if (app()->environment('production') && empty($tenant)) {
            throw new \Exception('Favor infomar o ID da loja');
        }
        if ($tenant) {
            $companies = Company::whereId($tenant)->firstOrFail();
            DropTenant::dispatch($companies);
        } else {
            $companies = Company::orderBy('created_at')->get();

            foreach ($companies as $company) {
                DropTenant::dispatch($company);
            }
        }

    }
}
