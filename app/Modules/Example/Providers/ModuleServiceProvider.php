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

    private function mapWebRoutes()
    {
        $strModuleName = $this->getModuleName();
        Route::group([
            'middleware' => 'api',
            'namespace' => '\App\Modules\\' . $strModuleName . '\Http\Controllers',
            'prefix' => strtolower($strModuleName),
            'as' => strtolower($strModuleName) . '.',
        ], function () {
            require app_path('Modules/' . $this->getModuleName() . '/Http/routes.php');
        });
    }

    /**
     * @return string
     */
    private function getModuleName(): string
    {
        return array_slice(explode('/', __DIR__), -2, 1)[0];
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
}
