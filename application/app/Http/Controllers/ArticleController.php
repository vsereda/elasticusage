<?php

namespace App\Http\Controllers;

use App\Contracts\Article\SearchEngine as SearchContract;
use App\Http\Requests\Article\SearchRequest;
use App\Http\Requests\Article\StoreRequest;
use App\Http\Requests\Article\UpdateRequest;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleSearchCollection;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::orderBy('id', 'desc')->paginate(5);
        return new ArticleCollection($articles);
    }

    public function store(StoreRequest $request)
    {
        $article = Article::create($request->all());
        return new ArticleResource($article);
    }

    public function show(Article $article)
    {
        return new ArticleResource($article);
    }

    public function update(UpdateRequest $request, Article $article)
    {
        $article->update($request->all());
        return new ArticleResource($article);
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return new ArticleResource($article);
    }

    public function search(SearchRequest $request, SearchContract $searching)
    {
        $searchPhrase = $request->input('search_phrase');
        $searchResult = $searching($searchPhrase);
        return new ArticleSearchCollection($searchResult);
    }
}
