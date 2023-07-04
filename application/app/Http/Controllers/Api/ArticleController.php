<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Article\SearchEngine as SearchContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Article\SearchRequest;
use App\Http\Requests\Article\StoreRequest;
use App\Http\Requests\Article\UpdateRequest;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleSearchCollection;
use App\Models\Article;

class ArticleController extends Controller
{
    /**
     * Return article list
     *
     * @return ArticleCollection
     */
    public function index()
    {
        $articles = Article::orderBy('id', 'desc')->paginate(5);
        return new ArticleCollection($articles);
    }

    /**
     * Store new article into db
     *
     * @param StoreRequest $request
     * @return ArticleResource
     */
    public function store(StoreRequest $request)
    {
        $article = Article::create($request->all());
        return new ArticleResource($article);
    }

    /**
     * Return article
     *
     * @param Article $article
     * @return ArticleResource
     */
    public function show(Article $article)
    {
        return new ArticleResource($article);
    }

    /**
     * Update article
     *
     * @param UpdateRequest $request
     * @param Article $article
     * @return ArticleResource
     */
    public function update(UpdateRequest $request, Article $article)
    {
        $article->update($request->all());
        return new ArticleResource($article);
    }

    /**
     * Drop article
     *
     * @param Article $article
     * @return ArticleResource
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return new ArticleResource($article);
    }

    /**
     * Search article
     *
     * @param SearchRequest $request
     * @param SearchContract $searching
     * @return ArticleSearchCollection
     */
    public function search(SearchRequest $request, SearchContract $searching)
    {
        $searchPhrase = $request->input('search_phrase');
        $searchResult = $searching($searchPhrase);
        return new ArticleSearchCollection($searchResult);
    }
}
