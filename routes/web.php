<?php

use Illuminate\Support\Facades\Route;

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
    return view('index');
});

Route::get('/cardapio', "CardapioController@index") ->name('cardapio');

Route::view('/sobre-nos', 'sobre_nos')->name('sobre_nos');

Route::get('/contato', function () {
    return view('contato');
});
