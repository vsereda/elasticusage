<?php

namespace App\Contracts\Article;

use ElasticScoutDriverPlus\Decorators\SearchResult;
use Illuminate\Support\Collection;

interface SearchResultFormatter
{
    public function __invoke(SearchResult $searchResult): Collection;
}
