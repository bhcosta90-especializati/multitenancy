<?php

namespace App\Jobs\Tenant;

use App\Models\Tenant\User;
use App\Tenant\Database\DatabaseManager;
use App\Tenant\ManagerTenant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;

class CreateDatabase implements ShouldQueue
{
    private $company;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($company)
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
        DatabaseManager::createDatabase($this->company);
        try {
            DatabaseManager::createUser($this->company);
        } catch (\Exception $e) {
        }
        DatabaseManager::previlegiesUser($this->company);
        Artisan::call("tenant:migrate {$this->company->id}");
        app(ManagerTenant::class)->setConnection($this->company);
        User::create([
            "name" => $this->company->name,
            "email" => "admin@admin.com.br",
            "password" => str_random(10),
            "company_id" => $this->company->id,
            'admin' => true,
        ]);
        config()->set('database.default', env('DB_CONNECTION', 'mysql'));

        $this->company->active = true;
        $this->company->save();
    }
}
