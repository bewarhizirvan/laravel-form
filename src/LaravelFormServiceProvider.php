<?php

namespace BewarHizirvan\LaravelForm;

use Illuminate\Support\ServiceProvider;

class LaravelFormServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'bewarhizirvan');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'bewarhizirvan');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravelform.php', 'laravelform');

        // Register the service the package provides.
        $this->app->singleton('laravelform', function ($app) {
            return new LaravelForm;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravelform'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/laravelform.php' => config_path('laravelform.php'),
        ], 'laravelform.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/bewarhizirvan'),
        ], 'laravelform.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/bewarhizirvan'),
        ], 'laravelform.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/bewarhizirvan'),
        ], 'laravelform.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
