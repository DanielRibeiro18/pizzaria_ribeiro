<?php

use App\Pedido;
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

Route::post('/pedido/adiciona/{produto}', 'PedidoController@adicionaProduto')->name('pedido.adiciona');

Route::post('/pedido/remove/{produto}', 'PedidoController@removeProduto')->name('pedido.remove');

//Route::get('/checkout', function () {
//
//    $usuario = auth()->user();
//    $pedido = Pedido::where('situacao', null)->where('usuarioId', $usuario->id)->firstOrCreate(['usuarioId' => $usuario->id]);
//    return view('checkout', ['produtos' => $pedido->produtos]);
//})->name('checkout');

Route::middleware('auth')->get('/checkout', 'PedidoController@checkout')->name('checkout');

Route::post('/checkout/finaliza', 'PedidoController@finalizar')->name('pedido.finaliza');

Route::post('/checkout/cupom/aplica', 'CupomController@aplicaCupom')->name('cupom.aplica');

Route::get('/finalpedido/{pedido}', 'PedidoController@finalizaPedido')->name('pedido.finalizado');
