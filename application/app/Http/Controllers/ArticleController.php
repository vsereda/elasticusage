<?php

namespace App\Http\Controllers;

use App\Contracts\Article\SearchResultFormatter as SearchResultFormatterContract;
use App\Contracts\Article\SearchEngine as SearchContract;
use App\Http\Requests\Article\SearchRequest;
use App\Http\Requests\Article\StoreRequest;
use App\Http\Requests\Article\UpdateRequest;
use App\Http\Resources\ArticleCollection;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        return new ArticleCollection(Article::orderBy('id', 'desc')->paginate(5));
    }

    public function store(StoreRequest $request)
    {
        $article = Article::create(['title' => $request->title, 'body' => $request->body,]);

        $success = $article instanceof Article;
        $articleId = $success ? $article->id : 0;

        return ['success' => $success, 'article_id' => $articleId];
    }

    public function show(Article $article)
    {
        return $article->only(['id', 'title', 'body']);
    }

    public function update(UpdateRequest $request, Article $article)
    {
        return ['success' => $article->update($request->only('title', 'body'))];
    }

    public function destroy(Article $article)
    {
        return ['success' => $article->delete()];
    }

    public function search(SearchRequest $request, SearchContract $searchEngine, SearchResultFormatterContract $formatter)
    {
        $searchStr = $request->input('search_string');
        $searchResult = $searchEngine($searchStr);
        $articles = $formatter($searchResult);

        return $articles->toArray();
    }
}
