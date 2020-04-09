<?php

namespace Wauxhall\VkAppsAuth;

use Illuminate\Support\ServiceProvider;
use Wauxhall\VkAppsAuth\Console\InitAppCommand;
use Wauxhall\VkAppsAuth\Console\RegisterAppCommand;
use Wauxhall\VkAppsAuth\Http\Middleware\CheckIsRequestFromRegisteredApp;
use Wauxhall\VkAppsAuth\Repositories\UserRepository;
use Wauxhall\VkAppsAuth\Repositories\VkAppRepository;
use Wauxhall\VkAppsAuth\Services\UserAuthService;
use Wauxhall\VkAppsAuth\Services\VkAppService;

class VkAppsAuthProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/vkapps.php', 'vkapps');

        $this->publishes([
            __DIR__ . '/../config/vkapps.php' => config_path('vkapps.php'),
        ], 'vkapps-config');

        $this->app['router']->aliasMiddleware('vkapps_signed', CheckIsRequestFromRegisteredApp::class);

        $this->loadRoutesFrom(__DIR__ . '/Routes/vkapps.php');

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'vkapps-migrations');

            $this->commands([
                RegisterAppCommand::class,
                InitAppCommand::class
            ]);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Wauxhall\VkAppsAuth\Contracts\Repositories\UserRepositoryInterface', function() {
            return new UserRepository();
        });

        $this->app->singleton('Wauxhall\VkAppsAuth\Contracts\UserAuthInterface', function() {
            return new UserAuthService($this->app->make('Wauxhall\VkAppsAuth\Contracts\Repositories\UserRepositoryInterface'));
        });

        $this->app->singleton('Wauxhall\VkAppsAuth\Contracts\Repositories\VkAppRepositoryInterface', function() {
            return new VkAppRepository();
        });

        $this->app->singleton('Wauxhall\VkAppsAuth\Contracts\VkAppInterface', function() {
            return new VkAppService($this->app->make('Wauxhall\VkAppsAuth\Contracts\Repositories\VkAppRepositoryInterface'));
        });
    }
}
