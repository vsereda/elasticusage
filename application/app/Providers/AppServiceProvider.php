<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use function Symfony\Component\String\s;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DB::listen(function ($query) {
             $sql = $query->sql;
             $bindings = $query->bindings;
//             $time = $query->time;
//             dump($sql);
//             dump($bindings);
        });
    }
}
