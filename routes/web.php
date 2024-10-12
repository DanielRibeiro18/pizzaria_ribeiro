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

Route::get('/admin', 'DashboardController@showDashboard')->name('dashboard');

Route::get('/admin/venda/diario', 'DashboardController@gerarGraficoDiario')->name('dashboard.grafico.diario');
Route::get('/admin/venda/semanal', 'DashboardController@gerarGraficoSemanal')->name('dashboard.grafico.semanal');
Route::get('/admin/venda/mensal', 'DashboardController@gerarGraficoMensal')->name('dashboard.grafico.mensal');

Route::get('/produto', 'ProdutoController@create')->name('produto');

Route::post('/cadproduto', 'ProdutoController@cadastro')->name('produto.cadastro');

Route::post('/login', 'AuthController@login')->name('usuario.login');

Route::get('/logout', 'AuthController@logout')->name('logout');

Route::post('/registro', 'UsuarioController@registro')->name('usuario.registro');

Route::get('/admin/usuario', 'UsuarioController@list')->name('usuario.list');

Route::post('/admin/usuario/{usuario}', 'UsuarioController@remover')->name('usuario.remove');

Route::get('/admin/usuario/{usuario}/edit', 'UsuarioController@edit')->name('usuario.edit');

Route::put('/admin/usuario/{usuario}', 'UsuarioController@update')->name('usuario.update');

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

Route::get('/admin/adicional', 'AdicionaisController@list')->name('adicional.list');

Route::post('admin/adicional', 'AdicionaisController@store')->name('adicional.store');

Route::post('admin/adicional/{adicional}', 'AdicionaisController@delete')->name('adicional.delete');

Route::get('/admin/horario', 'HorarioController@list')->name('horario.list');

Route::get('/admin/horario/{horario}/edit', 'HorarioController@edit')->name('horario.edit');

Route::put('/admin/horario/{horario}', 'HorarioController@update')->name('horario.update');
