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
                    'query' => 'Leixe',
                    'fuzziness' => 'AUTO'
                ]
            ]
        ];

        $result = User::searchQuery($query)
            ->highlight('name')
            ->execute();
        dump('1) $result = User::searchQuery($query)->highlight(\'name\')->execute()');
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

        dump('8) $match->highlight()->snippets(\'name\')');
        dump($match->highlight()->snippets('name'));
        dump('8) $highlight->snippets(\'name\')');
        dump($highlight->snippets('name'));

        dump('9) $document->content()');
        dump($document->content());

        dump("10) User::searchForm('Leixe')->execute()->models()");
        dump(User::searchForm('Leixe')->execute()->models());

        dump("11) User::searchForm('Leixe')->sort('_id', 'desc')->from(1)->size(1)->highlight('name')->execute()->models()");
        dump(User::searchForm('Leixe')->sort('_id', 'desc')->from(1)->size(1)->highlight('name')->execute()->models());
    }
}
