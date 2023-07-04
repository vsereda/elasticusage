<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Return start page for SPA
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('home');
    }
}
