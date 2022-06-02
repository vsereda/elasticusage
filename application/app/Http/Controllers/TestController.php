<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use ElasticScoutDriverPlus\Support\Query;

class TestController extends Controller
{
    public function test()
    {
//        dump(User::take(5)->get());
//        dump(User::search('Kuhlman')->first());
//        dump(User::search('name:(Kuhlman or Kuhlmon)')->first());
//        dump(User::search('*')->where('email', 'sabina25@example.net')->first());

//        $query = Query::match()
//            ->field('name')
//            ->query('Lavson')
//            ->fuzziness('AUTO')
//        ;

        $query = [
            'match' => [
                'name' => [
                    'query' => 'Lavson',
                    'fuzziness' => 'AUTO'
                ]
            ]
        ];

        $result = User::searchQuery($query)
            ->highlight('name')
            ->execute();
        dump('$result');
        dump($result);
        dump('models');
        dump($result->models()->all());
        dump('documents');
        dump($result->documents());

        $match = $result->hits()->first();
        dump('$match');
        dump($match);

        dump('document = $match->document()');
        dump($document = $match->document());

        dump('$match->model()');
        dump($match->model());

        dump('$highlight = $match->highlight()');
        dump($highlight = $match->highlight());

        dump('$match->highlight()->getSnippets(\'name\')');
        dump($highlight->snippets('name'));

        dump('$document->content()');
        dump($document->content());

        dump("User::searchForm('Lowson')->execute()->models()");
        dump(User::searchForm('Lowson')->execute()->models());

        dump("User::searchForm('Lowson')->sort('_id', 'desc')->from(1)->size(1)->highlight('name')->execute()->models()");
        dump(User::searchForm('Lowson')->sort('_id', 'desc')->from(1)->size(1)->highlight('name')->execute()->models());
    }
}
