<?php

namespace Raystech\LINEBot;

use Illuminate\Support\ServiceProvider;

class LINEBotServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'Raystech');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'Raystech');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {

            // Publishing the configuration file.
            $this->publishes([
                __DIR__.'/../config/linebot.php' => config_path('linebot.php'),
            ], 'linebot.config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => base_path('resources/views/vendor/Raystech'),
            ], 'Linebot.views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/Raystech'),
            ], 'Linebot.views');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/Raystech'),
            ], 'Linebot.views');*/

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
        $this->mergeConfigFrom(__DIR__.'/../config/linebot.php', 'linebot');

        // Register the service the package provides.
        $this->app->singleton('LINEBot', function ($app) {
            return new LINEBot;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['LINEBot'];
    }
}