<?php

namespace App\Providers;

use App\Models\Company;
use App\Support\VerifyManager;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        $namespace = $this->namespace . (VerifyManager::verify() ? "\\Main" : $this->getNamespace());
        $route = VerifyManager::verify() ? 'routes/api.php' : 'routes/api.tenant.php';

        Route::prefix('api')
            ->middleware('api')
            ->namespace($namespace)
            ->group(base_path($route));
    }

    private function getNamespace()
    {
        $company = Company::getCompanyByHost();
        $theme = str_replace('-', ' ', $company->theme);
        $themeReplace = preg_replace('/(?<!\ )[A-Z]/', ' $0', $theme);
        $themeClass = str_replace(' ', '', ucwords($theme));
        return "\\Tenant\\{$themeClass}";
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        $namespace = $this->namespace . (VerifyManager::verify() ? "\\Main" : $this->getNamespace());
        $route = VerifyManager::verify() ? 'routes/web.php' : 'routes/web.tenant.php';

        Route::middleware('web')
            ->namespace($namespace)
            ->group(base_path($route));
    }
}
