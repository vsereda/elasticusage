<?php

namespace App\Actions\Article;

use ElasticScoutDriverPlus\Decorators\SearchResult;
use Illuminate\Support\Collection;
use App\Contracts\Article\SearchResultFormatter as SearchResultFormatterContract;

class SearchResultFormatter implements SearchResultFormatterContract
{
    public function __invoke(SearchResult $searchResult): Collection
    {
        $articles = $searchResult->hits()->map(function ($item, $key) {
            $content = $item->document()->content();

            $titleSnippet = $item->highlight()->snippets('title')->first();
            $bodySnippets = $item->highlight()->snippets('body')
                ->map(function ($item) {
                    return $item . '...</br>';
                })->toArray();
            $bodySnippetJoined = join('', $bodySnippets);

            if ($titleSnippet) {
                $content['title'] = $titleSnippet;
            }

            $content['body_snippets'] = $bodySnippetJoined;

            $content['id'] = $item->document()->id();
            return $content;
        });

        return $articles;
    }
}
