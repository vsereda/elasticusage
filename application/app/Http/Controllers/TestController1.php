<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class TestController1 extends Controller
{
    public function test()
    {
        $input = 'seading';

        //        dump(Article::take(5)->get());
//        dump(Article::search('Kuhlman')->first());
//        dump(Article::search('$input:(Kuhlman or Kuhlmon)')->first());
//        dump(Article::search('*')->where('email', 'sabina25@example.net')->first());

//        $query = Query::match()
//            ->field('$input')
//            ->query('Lavson')
//            ->fuzziness('AUTO')
//        ;



        $query = [
            'match' => [
                'title' => [
                    'query' => $input,
                    'fuzziness' => 'AUTO'
                ]
            ]
        ];

        $result = Article::searchQuery($query)
            ->highlight('title')
            ->execute();
        dump('1) $result = Article::searchQuery($query)->highlight(\'title\')->execute()');
        dump($result);

        dump('2) $result->models()->all()');
        dump($result->models()->all());

        dump('3) $result->documents()');
        dump($result->documents());

        $match = $result->hits()->first();
        dump('4) $match = $result->hits()->first()');
        dump($match);

        $document = $match->document();
        dump('5) $document = $match->document()');
        dump($document);

        dump('6) $match->model()');
        dump($match->model());

        $highlight = $match->highlight();
        dump('7) $highlight = $match->highlight()');
        dump($highlight);

        dump('8) $match->highlight()->snippets(\'title\')');
        dump($match->highlight()->snippets('title'));
        dump('8) $highlight->snippets(\'title\')');
        dump($highlight->snippets('title'));

        dump('9) $document->content()');
        dump($document->content());

        dump("10) Article::searchForm('$input')->execute()->models()");
        dump(Article::searchForm($input)->execute()->models());

        dump("11) Article::searchForm('$input')->sort('_id', 'desc')->from(1)->size(1)->highlight('title')->execute()");
        dump(Article::searchForm($input)->sort('_id', 'desc')->from(0)->size(10)->highlight('title')->execute());

        dump("12) Article::searchForm('$input')->sort('_id', 'desc')->from(1)->size(1)->highlight('title')->execute()->models()");
        dump(Article::searchForm($input)->sort('_id', 'desc')->from(0)->size(10)->highlight('title')->execute()->models());


    }
}
