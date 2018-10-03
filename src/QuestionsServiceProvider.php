<?php

namespace WebHappens\Questions;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory as ModelFactory;

class QuestionsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerPublishing();
            $this->registerFactories();
        }

        $this->registerMigrations();
        $this->registerRoutes();
    }

    protected function registerPublishing()
    {
        $this->publishes([
            __DIR__ . '/../config/questions.php' => config_path('questions.php'),
        ]);
    }

    protected function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    protected function registerRoutes()
    {
        Route::middleware(config('questions.middleware', []))
            ->name('questions.')
            ->prefix(config('questions.path', '/questions'))
            ->namespace('WebHappens\\Questions\\Http\Controllers')
            ->group(function () {
                $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
            });
    }

    protected function registerFactories()
    {
        $this->app->make(ModelFactory::class)->load(__DIR__ . '/../database/factories');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/questions.php', 'questions');
    }
}
