<p align="center"><img height="188" width="198" src="https://botman.io/img/botman.png"></p>
<h1 align="center">Skeleton Laravel</h1>

## About

Initial skeleton for design in Laravel API architecture.

## Installation

Register each module provider on config/app.php file on 'providers' array
    App\Modules\Example\Providers\ModuleServiceProvider::class,
    
composer install

php artisan passport:keys

php artisan migrate --path=/app/Modules/Example/Database/Migrations 

php artisan db:seed --class="App\Modules\Example\Database\Seeds\DefaultSeeder"

If needed register yours Factories on App\Core\Providers\AppServiceProvider

## License

Skeleton Laravel is free software distributed under the terms of the MIT license.

