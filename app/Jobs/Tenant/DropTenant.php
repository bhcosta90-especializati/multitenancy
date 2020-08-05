<?php

namespace App\Jobs\Tenant;

use App\Models\Company;
use App\Tenant\Database\DatabaseManager;
use App\Tenant\ManagerTenant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DropTenant implements ShouldQueue
{
    private $company;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        app(ManagerTenant::class)->setConnection($this->company);
        DatabaseManager::dropDatabase($this->company);
        config()->set('database.default', env('DB_CONNECTION', 'mysql'));
        $this->company->delete();
    }
}
