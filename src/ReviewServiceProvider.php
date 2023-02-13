<?php

namespace  MohamadSaleh\Reviewable;

use Illuminate\Support\ServiceProvider;

class ReviewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            \dirname(__DIR__).'/migrations/' => database_path('migrations'),
        ], 'review-migrations');

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(\dirname(__DIR__).'/migrations/');
        }
    }
}
