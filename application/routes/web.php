<?php

use App\Http\Controllers\TestController1;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::controller(TestController::class)->group(function () {
    Route::get('/test', 'test');
});

Route::controller(TestController1::class)->group(function () {
    Route::get('/test1', 'test');
});

Route::get('{any?}', function () {
    return view('home');
})->where('any', '.*');
