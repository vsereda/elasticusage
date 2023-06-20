<?php

namespace App\Providers;

use App\Actions\Article\ElasticSearchEngine;
use App\Contracts\Article\SearchEngine as ArticleSearchContract;
use Illuminate\Support\ServiceProvider;

class ActionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ArticleSearchContract::class, ElasticSearchEngine::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
