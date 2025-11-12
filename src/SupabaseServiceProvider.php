<?php

namespace Saeedvir\Supabase;

use Illuminate\Support\ServiceProvider;
use Saeedvir\Supabase\Services\SupabaseService;

class SupabaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/supabase.php', 'supabase'
        );

        $this->app->singleton('supabase', function ($app) {
            return new SupabaseService();
        });

        $this->app->bind('Saeedvir\Supabase\Services\SupabaseService', function ($app) {
            return new SupabaseService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/supabase.php' => config_path('supabase.php'),
            ], 'supabase-config');
        }
    }
}