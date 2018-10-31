<?php

namespace WebHappens\Questions\Nova;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use WebHappens\Questions\Nova\Resources\Answer;
use WebHappens\Questions\Nova\Resources\Referer;
use WebHappens\Questions\Nova\Resources\Question;
use WebHappens\Questions\Nova\Resources\Response;
use Webhappens\Questions\Http\Middleware\Authorize;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'nova-questions');

        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            $this->resources();
        });
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class])
                ->prefix('nova-vendor/webhappens/nova-questions')
                ->group(__DIR__.'/../routes/api.php');
    }

    protected function resources()
    {
        Nova::resources([
            Question::class,
            Answer::class,
            Referer::class,
            Response::class,
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
