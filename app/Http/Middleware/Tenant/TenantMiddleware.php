<?php

namespace App\Http\Middleware\Tenant;

use App\Models\Company;
use App\Support\VerifyManager;
use App\Tenant\ManagerTenant;
use Closure;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!VerifyManager::verify()) {
            $company = $this->getCompany($request->getHost());

            #TODO fazer a parte de subdominio
            if (empty($company)) {
                $company = $this->getCompany(collect(explode('.', $request->getHost()))->first());
            }
            
            if (empty($company)) {
                abort(404);
            }
    
            app(ManagerTenant::class)->setConnection($company)->setView($company);
        }
        
        return $next($request);
    }

    public function getCompany(string $host): ?Company{
        return Company::whereDomain($host)->first();
    }
}
