<?php

namespace App\Http\Controllers;

use App\Horario;
use App\ItemPedido;
use App\Pedido;
use App\Produto;
use App\Usuario;
use App\Bairro;
use App\Cupom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PedidoController extends Controller
{
    public function adicionaProduto(Request $request, Produto $produto)
    {
        // Obtenha o dia da semana em formato abreviado (ex: 'Tue', 'Wed')
        $dia = now()->format('D');
        $horaAtual = now()->hour;

        $horario = Horario::where('dia_semana', Horario::hoje())->first();

        if(!$horario->estaAberto()){
            return redirect(route('cardapio'))->withErrors(['message' => 'O carrinho está disponível apenas de terça-feira a domingo, das 18h às 23h.']);
        }

        $usuario = auth()->user();
        $pedido = Pedido::where('situacao', null)->where('usuarioId', $usuario->id)->firstOrCreate(['usuarioId' => $usuario->id]);

        $eMeioaMeio = null;

        if($request->metadeId == ''){
            $eMeioaMeio = false;
        } else {
            $eMeioaMeio = true;
        }

        $pedido->produtos()->save($produto, [
            'adicional1Id' => $request->adicional1Id,
            'adicional2Id' => $request->adicional2Id,
            'observacao' => $request->observacao,
            'eMeioaMeio' => $eMeioaMeio,
            'metadeId' => $request->metadeId
        ]);

        session(['itens_carrinho' => $pedido->produtos()->count()]);

        return redirect(route('cardapio'));
    }

    public function removeProduto(Request $request, ItemPedido $produto)
    {
        $usuario = auth()->user();

        $pedido = Pedido::where('situacao', null)->where('usuarioId', $usuario->id)->firstOrCreate(['usuarioId' => $usuario->id]);

//        $pedido->produtos()->detach($produto);
        $produto->delete();

        session(['itens_carrinho' => $totalProdutos = $pedido->produtos->count()]);

        if($totalProdutos == 0){
            return redirect(route('cardapio'));
        }

        return redirect(route('checkout'));
    }

    public function checkout()
    {
        $totalProdutos = session()->get('itens_carrinho');

        if(intval($totalProdutos) == 0){
            return redirect(route('cardapio'));
        }

        $usuario = auth()->user();
        $pedido = Pedido::where('situacao', null)
            ->where('usuarioId', $usuario->id)
            ->firstOrCreate(['usuarioId' => $usuario->id]);

        $produtos = $pedido->produtos;

        $totalAdicionais = 0;

        foreach($produtos as $produto){
            if($produto->pivot->adicional1 != null){
                $totalAdicionais += $produto->pivot->adicional1->valor;
            }
            if($produto->pivot->adicional2 != null){
                $totalAdicionais += $produto->pivot->adicional2->valor;
            }
        }

        $totalProdutos = 0;

        $dia = now()->format('D');

        if ($pedido->cupom != null && $pedido->cupom->data_valida == $dia) {

            $categorias = $pedido->cupom->categorias->pluck('id')->toArray();

            foreach($produtos as $produto){
                if(in_array($produto->categoria->id, $categorias)){

                    if($produto->pivot->eMeioaMeio){
                        $metade = $produto->pivot->metade;

                        $media = ($produto->preco + $metade->preco ) / 2;

                        $totalProdutos += $media - ($media * ($pedido->cupom->valor / 100));
                    } else {
                        $totalProdutos += $produto->preco - ($produto->preco * ($pedido->cupom->valor / 100));
                    }

                } else {

                    if($produto->pivot->eMeioaMeio){
                        $metade = $produto->pivot->metade;

                        $media = ($produto->preco + $metade->preco ) / 2;

                        $totalProdutos += $media;
                    } else {
                        $totalProdutos += $produto->preco;
                    }

                }

            }

        } else {

            foreach ($produtos as $produto){
                if($produto->pivot->eMeioaMeio){
                    $metade = $produto->pivot->metade;

                    $media = ($produto->preco + $metade->preco ) / 2;

                    $totalProdutos += $media;
                } else {
                    $totalProdutos += $produto->preco;
                }
            }

        }

        $totalPreco = $totalProdutos + $totalAdicionais;


        if($pedido->cupom != null){
            $nomeCupom = $pedido->cupom->nome;
            $valorCupom = $pedido->cupom->valor;
            $descCategoria = $pedido->cupom->categorias->first()->descricao;
        } else {
            $nomeCupom = null;
            $valorCupom = null;
            $descCategoria = null;
        }

        // Obtenha todos os bairros
        $bairros = Bairro::all();

        return view('checkout', [
            'produtos' => $produtos,
            'totalPreco' => $totalProdutos + $totalAdicionais,
            'totalCupom' => $totalPreco,
            'nomeCupom' => $nomeCupom,
            'valorCupom' => $valorCupom,
            'descCategoria' => $descCategoria,
            'bairros' => $bairros
        ]);
    }

    public function list(Request $request)
    {
        $horarios = Horario::all();

        // Carrega os pedidos com os produtos relacionados, já usando eager loading
        $pedidos = Pedido::with('produtos', 'bairro')->get();

        return view('admin.pedidos.index', [
            'horarios' => $horarios,
            'pedidos' => $pedidos
        ]);
    }

    public function cancelarPedido(Request $request, $id)
    {
        // Encontrar o pedido pelo ID
        $pedido = Pedido::findOrFail($id);

        // Atualizar o status do pedido para 'cancelado'
        $pedido->situacao = 'cancelado';

        // Salvar o motivo do cancelamento
        $pedido->motivo_cancelamento = $request->input('motivo');

        // Salvar as alterações no banco de dados
        $pedido->save();

        // Redirecionar com uma mensagem de sucesso
        return redirect()->back()->with('success', 'Pedido cancelado com sucesso!');
    }

    public function finalizar(Request $request)
    {
        $usuario = auth()->user();

        // Buscar o pedido atual ou criar um novo
        $pedido = Pedido::where('situacao', null)
            ->where('usuarioId', $usuario->id)
            ->firstOrCreate(['usuarioId' => $usuario->id]);

        // Verificar o bairro pelo CEP
        $bairro = Bairro::where('nome', $request->bairro)->first();

        if (!$bairro) {
            return redirect()->back()->with('error', 'Bairro não encontrado para o CEP informado.');
        }

        // Atualizar informações do pedido
        $pedido->situacao = 'pendente';
        $pedido->taxa_entrega = $request->taxa_entrega;
        $pedido->valor_produtos = $pedido->produtos->sum('preco');
        $pedido->forma_pagamento = $request->forma_pagamento;
        $pedido->troco = $request->troco;
        $pedido->subtotal = $request->subtotal;
        $pedido->endereco = $request->cep . ' - ' . $request->logradouro . ' - ' . $request->numero . ' - ' . $request->complemento;
        $pedido->referencia = $request->referencia;

        // Atribuir o bairroId ao pedido
        $pedido->bairroId = $bairro->id;

        // Salvar o pedido no banco de dados
        $pedido->save();

        // Limpar o carrinho
        session()->put('itens_carrinho', 0);

        // Redirecionar para a página de pedido finalizado
        return redirect(route('pedido.finalizado', $pedido->id));
    }

    public function voltarSituacao($id)
    {
        $pedido = Pedido::find($id);

        // Array de situações possíveis
        $situacoes = ['pendente', 'em preparo', 'saiu para entrega', 'finalizado'];

        // Encontrar a situação atual no array e voltar uma posição, se possível
        $index = array_search($pedido->situacao, $situacoes);

        if ($index > 0) {
            $pedido->situacao = $situacoes[$index - 1];
            $pedido->save();
        }

        return redirect()->back()->with('success', 'Situação do pedido atualizada!');
    }

    public function avancarSituacao($id)
    {
        $pedido = Pedido::find($id);

        // Array de situações possíveis
        $situacoes = ['pendente', 'em preparo', 'saiu para entrega', 'finalizado'];

        // Encontrar a situação atual no array e avançar uma posição, se possível
        $index = array_search($pedido->situacao, $situacoes);

        if ($index < count($situacoes) - 1) {
            $pedido->situacao = $situacoes[$index + 1];
            $pedido->save();
        }

        return redirect()->back()->with('success', 'Situação do pedido atualizada!');
    }


    public function finalizaPedido(Pedido $pedido)
    {
        // Carrega os produtos relacionados ao pedido
        $pedido->load('produtos');

        // Retorna a view com o pedido
        return view('finalpedido', ['pedido' => $pedido]);
    }

    public function gerarPdf()
    {
        $pedidos = Pedido::with(['usuario', 'produtos', 'bairro', 'cupom'])
            ->orderBy('created_at')
            ->get();

        // Caminho da logo (ajuste conforme necessário)
        $logoPath = 'C:/Users/Dan/Documents/Projeto/pizzaria_ribeiro/public/site/img/logo.png';

        // Data atual
        $dataAtual = date('d/m/Y H:i');

        // Gera o conteúdo HTML do relatório
        $html = '
<div style="text-align: center;">
    <img src="' . $logoPath . '" alt="Logo" style="width: 150px; height: auto; margin-bottom: 20px;">
    <h1>Relatório de Pedidos</h1>
    <p>Data: ' . $dataAtual . '</p>
</div>
<table border="1" cellspacing="0" cellpadding="5" style="width: 100%; text-align: left; margin: 0 auto; font-size: 10px;">
    <thead>
        <tr>
            <th style="text-align: center;">Pedido</th>
            <th style="text-align: center;">Usuário</th>
            <th style="text-align: center;">Endereço</th>
            <th style="text-align: center;">Produtos</th>
            <th style="text-align: center;">Situação</th>
            <th style="text-align: center;">Taxa de Entrega</th>
            <th style="text-align: center;">Cupom Aplicado</th>
            <th style="text-align: center;">Total</th>
        </tr>
    </thead>
    <tbody>';

        foreach ($pedidos as $pedido) {
            $html .= '<tr>';
            $html .= '<td style="text-align: center;">#' . $pedido->id . '</td>';
            $html .= '<td style="text-align: center;">' . htmlspecialchars($pedido->usuario->nome) . '</td>';
            $html .= '<td style="text-align: center;">' . htmlspecialchars($pedido->bairro->cidade . ' - ' . $pedido->endereco) . '</td>';
            $html .= '<td>';

            // Lista os produtos do pedido com mais espaçamento
            foreach ($pedido->produtos as $produto) {
                // Aumenta o espaçamento entre cada produto
                $html .= '<div style="margin-bottom: 15px;">';  // Aumenta o espaçamento entre os produtos
                $html .= htmlspecialchars($produto->nome) . ' (' . $produto->tamanho . ') - R$ ' . number_format($produto->preco, 2, ',', '.') . '<br>';

                if ($produto->pivot->eMeioaMeio) {
                    $html .= 'Meio a Meio: ' . htmlspecialchars($produto->pivot->metade->nome) . ' (' . $produto->pivot->metade->tamanho . ') - R$ ' . number_format($produto->pivot->metade->preco, 2, ',', '.') . '<br>';
                }

                if ($produto->pivot->adicional1) {
                    $html .= 'Adicional 1: ' . htmlspecialchars($produto->pivot->adicional1->nome) . ' - R$ ' . number_format($produto->pivot->adicional1->valor, 2, ',', '.') . '<br>';
                }

                if ($produto->pivot->adicional2) {
                    $html .= 'Adicional 2: ' . htmlspecialchars($produto->pivot->adicional2->nome) . ' - R$ ' . number_format($produto->pivot->adicional2->valor, 2, ',', '.') . '<br>';
                }
                $html .= '</div>';
            }

            $html .= '</td>';
            $html .= '<td style="text-align: center;">' . htmlspecialchars($pedido->situacao) . '</td>';

            // Exibe a taxa de entrega
            $html .= '<td style="text-align: center;">R$ ' . number_format($pedido->taxa_entrega, 2, ',', '.') . '</td>';

            // Exibe o cupom se houver
            if ($pedido->cupom) {
                $html .= '<td style="text-align: center;">' . htmlspecialchars($pedido->cupom->nome) . ' - ' . $pedido->cupom->valor . '%</td>';
            } else {
                $html .= '<td style="text-align: center;">Nenhum</td>';
            }

            $html .= '<td style="text-align: center;">R$ ' . number_format($pedido->subtotal, 2, ',', '.') . '</td>';
            $html .= '</tr>';

            // Adiciona uma linha em branco para separar os pedidos
            $html .= '<tr><td colspan="8" style="height: 20px;"></td></tr>';
        }

        $html .= '</tbody></table>';

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);

        return $mpdf->Output('relatorio_pedidos.pdf', 'D');
    }





}
