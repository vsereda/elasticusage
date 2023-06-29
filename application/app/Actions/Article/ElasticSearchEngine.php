<?php

namespace App\Actions\Article;

use App\Contracts\Article\SearchEngine as SearchContract;
use App\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ElasticSearchEngine implements SearchContract
{
    public function __invoke(string $searchStr): LengthAwarePaginator
    {
        $SearchResult = Article::searchForm($searchStr)
            ->sort('_score', 'desc')
            ->highlight('title')
            ->highlight('body')
            ->trackScores(true)
            ->paginate(5);

        return $SearchResult;
    }
}
