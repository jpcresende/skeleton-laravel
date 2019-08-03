<?php


namespace App\Modules\Example\Providers;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

/**
 * Class ModuleServiceProvider
 * @package App\Modules\Example\Providers
 */
class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mapWebRoutes();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function mapWebRoutes()
    {
        Route::group([
            'middleware'    => 'api',
            'namespace'     => '\App\Modules\Example\Http\Controllers',
            'prefix'        => 'example',
            'as'            => 'example.',
        ], function () {
            require app_path('Modules/Example/Http/routes.php');
        });
    }
}
