<?php

namespace App\Console\Commands\Tenant;

use App\Jobs\Tenant\DropTenant;
use App\Models\Company;
use App\Tenant\ManagerTenant;
use Illuminate\Console\Command;

class TenantDrop extends Command
{
    private $tenant;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:drop {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

        $companies = Company::whereId($tenant)->firstOrFail();

        DropTenant::dispatch($companies);
    }
}
