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

Route::get('/admin/dashboard', 'DashboardController@showDashboard')->name('dashboard');

Route::get('/admin/venda/diario', 'DashboardController@gerarGraficoDiario')->name('dashboard.grafico.diario');
Route::get('/admin/venda/semanal', 'DashboardController@gerarGraficoSemanal')->name('dashboard.grafico.semanal');
Route::get('/admin/venda/mensal', 'DashboardController@gerarGraficoMensal')->name('dashboard.grafico.mensal');

Route::get('/gerar-pdf/{tipo}', 'DashboardController@gerarPdf')->name('dashboard.gerarPdf');

Route::post('/login', 'AuthController@login')->name('usuario.login');

Route::get('/logout', 'AuthController@logout')->name('logout');

Route::post('/registro', 'UsuarioController@registro')->name('usuario.registro');

Route::post('/registroadmin', 'UsuarioController@registroadmin')->name('usuario.registroadmin');

Route::get('/admin/usuario', 'UsuarioController@list')->name('usuario.list');

Route::get('/admin/usuario/relatorio', 'UsuarioController@gerarPdf')->name('usuario.gerarPdf');

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

Route::get('admin/adicionais/relatorio', 'AdicionaisController@gerarPdf')->name('adicional.gerarPdf');

Route::get('/admin/horario', 'HorarioController@list')->name('horario.list');

Route::get('/admin/horario/{horario}/edit', 'HorarioController@edit')->name('horario.edit');

Route::put('/admin/horario/{horario}', 'HorarioController@update')->name('horario.update');

Route::get('admin/horario/relatorio', 'HorarioController@gerarPdf')->name('horario.gerarPdf');

Route::get('/admin/produto', 'ProdutoController@create')->name('produto.list');

Route::post('/admin/cadproduto', 'ProdutoController@cadastro')->name('produto.cadastro');

Route::get('/admin/produto/{produto}/edit', 'ProdutoController@edit')->name('produto.edit');

Route::put('/admin/produto/{produto}', 'ProdutoController@update')->name('produto.update');

Route::post('/admin/produto/{produto}', 'ProdutoController@remove')->name('produto.remove');

Route::get('admin/produto/relatorio', 'ProdutoController@gerarPdf')->name('produto.gerarPdf');

Route::get('/admin/pedido', 'PedidoController@list')->name('pedido.list');

Route::post('/pedido/cancelar/{id}', 'PedidoController@cancelarPedido')->name('pedido.cancelar');

Route::post('/admin/pedido/{id}/voltar-situacao', 'PedidoController@voltarSituacao')->name('pedido.voltarSituacao');
Route::post('/admin/pedido/{id}/avancar-situacao', 'PedidoController@avancarSituacao')->name('pedido.avancarSituacao');

Route::get('admin/pedido/relatorio', 'PedidoController@gerarPdf')->name('pedido.gerarPdf');

Route::get('/admin/categoria', 'CategoriaController@list')->name('categoria.list');

Route::post('/admin/categoria', 'CategoriaController@registro')->name('categoria.registro');

Route::post('/admin/categoria/{categoria}', 'CategoriaController@remover')->name('categoria.remove');

Route::get('/admin/categoria/{categoria}/edit', 'CategoriaController@edit')->name('categoria.edit');

Route::put('/admin/categoria/{categoria}', 'CategoriaController@update')->name('categoria.update');

Route::get('admin/categoria/relatorio', 'CategoriaController@gerarPdf')->name('categoria.gerarPdf');

Route::get('/admin/cupom', 'CupomController@list')->name('cupom.list');

Route::post('/admin/cupom', 'CupomController@registro')->name('cupom.registro');

Route::post('/admin/cupom/{cupom}', 'CupomController@remover')->name('cupom.remove');

Route::get('/admin/cupom/{cupom}/edit', 'CupomController@edit')->name('cupom.edit');

Route::put('/admin/cupom/{cupom}', 'CupomController@update')->name('cupom.update');

Route::get('admin/cupom/relatorio', 'CupomController@gerarPdf')->name('cupom.gerarPdf');
