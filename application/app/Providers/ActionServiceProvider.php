<?php

namespace App\Providers;

use App\Actions\Article\SearchEngineEngine;
use App\Actions\Article\SearchResultFormatter;
use App\Contracts\Article\SearchEngine as ArticleSearchContract;
use App\Contracts\Article\SearchResultFormatter as SearchResultFormatterContract;
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
        $this->app->bind(ArticleSearchContract::class, SearchEngineEngine::class);
        $this->app->bind(SearchResultFormatterContract::class, SearchResultFormatter::class);
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
