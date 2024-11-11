<?php

namespace App\Http\Controllers;

use App\Horario;
use Mpdf\Mpdf;
use Illuminate\Http\Request;

class HorarioController extends Controller
{

    public function list(Request $request)
    {
        $horarios = Horario::all();

        return view('admin.horarios.index', ['horarios' => $horarios]);
    }

    public function edit(Request $request, Horario $horario)
    {
        return view('admin.horarios.edit', ['horario' => $horario]);
    }

    public function update(Request $request, Horario $horario)
    {
        // Atualiza o valor de 'fechado' com base no checkbox
        $horario->fechado = $request->has('fechado');

        // Mantém os valores de hora_abertura e hora_fechamento
        $horario->hora_abertura = $request->hora_abertura;
        $horario->hora_fechamento = $request->hora_fechamento;

        $horario->save();

        return redirect(route('horario.list'));
    }

    public function gerarPdf()
    {
        // Busca todos os horários
        $horarios = Horario::all(); // Ajuste o modelo conforme necessário

        // Verifica se há horários para incluir no relatório
        if ($horarios->isEmpty()) {
            return redirect()->back()->with('error', 'Nenhum horário encontrado para gerar o relatório.');
        }

        // Caminho da logo (ajuste conforme necessário)
        $logoPath = 'C:/Users/Dan/Documents/Projeto/pizzaria_ribeiro/public/site/img/logo.png';

        // Gera o conteúdo HTML do relatório
        $html = '
    <div style="text-align: center;">
        <img src="' . $logoPath . '" alt="Logo" style="width: 150px; height: auto; margin-bottom: 20px;">
        <h1>Relatório de Horários</h1>
    </div>
    <table border="1" cellspacing="0" cellpadding="5" style="width: 100%; text-align: left; margin: 0 auto;">
        <thead>
            <tr>
                <th style="text-align: center;">Dia da Semana</th>
                <th style="text-align: center;">Hora de Abertura</th>
                <th style="text-align: center;">Hora de Fechamento</th>
            </tr>
        </thead>
        <tbody>';

        // Preenche a tabela com os horários
        foreach ($horarios as $horario) {
            $html .= '<tr>';
            $html .= '<td style="text-align: center;">' . htmlspecialchars($horario->dia_semana) . '</td>'; // Centraliza o texto
            $html .= '<td style="text-align: center;">' . htmlspecialchars($horario->hora_abertura) . '</td>'; // Centraliza o texto
            $html .= '<td style="text-align: center;">' . htmlspecialchars($horario->hora_fechamento) . '</td>'; // Centraliza o texto
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';

        // Gera o PDF usando mPDF
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        // Output do PDF para download
        return $mpdf->Output('relatorio_horarios.pdf', 'D'); // 'D' para forçar download
    }

}
