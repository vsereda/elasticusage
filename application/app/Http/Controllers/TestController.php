<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class TestController extends Controller
{
    public function test()
    {
        dump(User::take(5)->get());
        dump(User::search('Kuhlman')->first());
        dump(User::search('name:(Kuhlman or Kuhlmon)')->first());
        dump(User::search('*')->where('email', 'sabina25@example.net')->first());


    }
}
