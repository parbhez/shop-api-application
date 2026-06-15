<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Dedoc\Scramble\Scramble::afterOpenApiGenerated(function (\Dedoc\Scramble\Support\Generator\OpenApi $openApi) {
            $openApi->secure(
                \Dedoc\Scramble\Support\Generator\SecurityScheme::http('bearer')
            );
        });

        // Allow everyone to access the API docs (especially useful for local network access like 192.168.x.x)
        \Illuminate\Support\Facades\Gate::define('viewApiDocs', function ($user = null) {
            return true; // TODO: after production move this line code and return false

        });
    }
}
