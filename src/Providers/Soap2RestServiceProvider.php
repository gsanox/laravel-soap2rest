<?php
 
 namespace gsanox\Soap2Rest\Providers;
 
 use Illuminate\Support\Facades\Route;
 use Illuminate\Support\ServiceProvider;
 
 class Soap2RestServiceProvider extends ServiceProvider
 {
     public function boot()
     {
         $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
 
         $this->publishes([
             __DIR__.'/../../database/migrations/' => database_path('migrations')
         ], 'migrations');
 
         $this->publishes([
             __DIR__.'/../../config/soap2rest.php' => config_path('soap2rest.php'),
         ], 'config');
 
         // Load the package's routes
         Route::prefix(config('soap2rest.prefix', 'api'))
              ->middleware(config('soap2rest.middleware', ['api', 'auth:sanctum']))
              ->group(function () {
                  $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');
              });
     }
 
     public function register()
     {
         $this->mergeConfigFrom(
             __DIR__.'/../../config/soap2rest.php', 'soap2rest'
         );
     }
 }