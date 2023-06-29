<?php

namespace App\Contracts\Article;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SearchEngine
{
    public function __invoke(string $searchStr): LengthAwarePaginator;
}
