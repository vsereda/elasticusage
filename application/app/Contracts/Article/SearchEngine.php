<?php

namespace App\Contracts\Article;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SearchEngine
{
    /**
     * Must return search results with paginator
     *
     * @param string $searchStr
     * @return LengthAwarePaginator
     */
    public function __invoke(string $searchStr): LengthAwarePaginator;
}
