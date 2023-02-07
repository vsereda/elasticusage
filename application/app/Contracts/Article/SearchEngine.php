<?php

namespace App\Contracts\Article;

use ElasticScoutDriverPlus\Decorators\SearchResult;

interface SearchEngine
{
    public function __invoke(string $searchStr): SearchResult;
}
