<?php

namespace App\Http\Controllers;

use App\Http\Requests\Article\SearchRequest;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Article::orderBy('id', 'desc')->select('id', 'title', 'body')->paginate(5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $articleId = Article::insertGetId([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return ['success' => $articleId > 0, 'article_id' => $articleId];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return array|\Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return $article->only(['id', 'title', 'body']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return array|\Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        return ['success' => $article->update($request->only('title', 'body'))];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //
    }

    public function search(SearchRequest $request)
    {
        $searchStr = $request->search_string;

        $articles = Article::searchForm($searchStr)
            ->sort('_score', 'desc')
            ->from(0)
            ->size(10)
            ->highlight('title')
            ->highlight('body')
            ->trackScores(true)
            ->execute();
        $articles_result = ($articles->hits()->map(function ($item, $key) {
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
        }));

        return $articles_result->toArray();
    }
}
