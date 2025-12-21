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
     
             // Load the package's routes
             Route::prefix('api')
                  ->middleware('api')
                  ->group(function () {
                      $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');
                  });
         } 
     public function register()
     {
         // You can register your services here if needed
     }
 }