<?php

namespace App\Actions\Article;

use App\Contracts\Article\SearchEngine as SearchContract;
use App\Models\Article;
use ElasticScoutDriverPlus\Decorators\SearchResult;

class SearchEngineEngine implements SearchContract
{
    public function __invoke(string $searchStr): SearchResult
    {
        $SearchResult = Article::searchForm($searchStr)
            ->sort('_score', 'desc')
            ->from(0)
            ->size(10)
            ->highlight('title')
            ->highlight('body')
            ->trackScores(true)
            ->execute();

        return $SearchResult;
    }
}
