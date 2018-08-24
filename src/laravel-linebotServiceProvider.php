<?php

namespace raystech\laravel-linebot;

use Illuminate\Support\ServiceProvider;

class laravel-linebotServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'raystech');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'raystech');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {

            // Publishing the configuration file.
            $this->publishes([
                __DIR__.'/../config/laravel-linebot.php' => config_path('laravel-linebot.php'),
            ], 'laravel-linebot.config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => base_path('resources/views/vendor/raystech'),
            ], 'laravel-linebot.views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/raystech'),
            ], 'laravel-linebot.views');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/raystech'),
            ], 'laravel-linebot.views');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-linebot.php', 'laravel-linebot');

        // Register the service the package provides.
        $this->app->singleton('laravel-linebot', function ($app) {
            return new laravel-linebot;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravel-linebot'];
    }
}