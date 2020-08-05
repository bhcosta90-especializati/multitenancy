<?php

namespace App\Http\Middleware\Tenant;

use App\Models\Company;
use App\Support\VerifyManager;
use App\Tenant\ManagerTenant;
use Closure;
use Illuminate\Support\Facades\Route;

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
            $company = Company::getCompanyByHost();

            if (empty($company)) {
                abort(404);
            }

            if($company->active == false && $request->url() != route('migrate')){
                return redirect()->route('migrate');
            } else if($request->url() == route('migrate') && $company->active == false){
                return $next($request);
            } else if($request->url() == route('migrate') && $company->active == true){
                return redirect()->route('home');
            }
            app(ManagerTenant::class)->setConnection($company)->setView($company);
        }

        return $next($request);
    }
}
