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
})->name('index');

Route::get('/cardapio', 'ProdutoController@index')->name('cardapio');

Route::view('/sobre-nos', 'sobre_nos')->name('sobre_nos');

Route::get('/contato', function () {
    return view('contato');
})->name('contato');

Route::get('/registro', function () {
    return view('registro');
})->name('registro');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/produto', 'ProdutoController@create')->name('produto');

Route::post('/cadproduto', 'ProdutoController@cadastro')->name('produto.cadastro');

Route::post('/login', 'AuthController@login')->name('usuario.login');

Route::get('/logout', 'AuthController@logout')->name('logout');

Route::post('/registro', 'UsuarioController@registro')->name('usuario.registro');
