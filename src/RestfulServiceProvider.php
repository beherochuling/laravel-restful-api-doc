<?php
namespace OlderW\RestfulDoc;

use Illuminate\Support\ServiceProvider;

class RestfulServiceProvider extends ServiceProvider {
    protected $commands = [
        'OlderW\RestfulDoc\Console\ApiCommand',
    ];

    public function boot() {
        if ( $this->app->runningInConsole() ) {
            $this->publishes([__DIR__.'/../config' => config_path()], 'laravel-restfuldoc-config');
        }
    }
    public function register() {
        $this->loadAdminAuthConfig();

        $this->commands($this->commands);
    }
    protected function loadAdminAuthConfig() {
        config(array_dot(config('restfulapi.auth', []), 'auth.'));
    }
}
