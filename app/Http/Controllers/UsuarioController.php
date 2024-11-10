<?php

namespace App\Http\Controllers;

use App\Usuario;
use Mpdf\Mpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function registro(Request $request)
    {
        // Função para validar CPF
        function validaCpf($cpf)
        {
            // Elimina possíveis máscaras
            $cpf = preg_replace('/\D/', '', $cpf);

            // Verifica se o número de dígitos é igual a 11
            if (strlen($cpf) != 11) {
                return false;
            }

            // Verifica se todos os dígitos são iguais (não é um CPF válido)
            if (preg_match('/(\d)\1{10}/', $cpf)) {
                return false;
            }

            // Calcula os dígitos verificadores
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf[$c] * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf[$c] != $d) {
                    return false;
                }
            }

            return true;
        }

        // Remove caracteres não numéricos do CPF
        $cpfNumeros = preg_replace('/\D/', '', $request->cpf);


        $telefonelimpo = preg_replace('/\D/', '', $request->telefone);

        // Valida se o CPF é válido
        if (!validaCpf($cpfNumeros)) {
            return redirect(route('registro'))->with('Erro', 'CPF inválido!');
        }

        // Verifica se o e-mail já existe
        $emailexiste = Usuario::where('email', $request->email)->count();
        if ($emailexiste >= 1) {
            return redirect(route('registro'))->with('Erro', 'Email já existente!');
        }

        if ($request->senha != $request->confirma_senha) {
            return redirect(route('registro'))->with('Erro', 'As senhas não são iguais!');
        }

        // Verifica se o e-mail já existe
        $telefoneexiste = Usuario::where('telefone', $request->telefone)->count();
        if ($telefoneexiste >= 1) {
            return redirect(route('registro'))->with('Erro', 'Telefone já existente!');
        }

        // Verifica se o CPF já existe na tabela de usuários
        $cpfExistente = Usuario::where('cpf', $cpfNumeros)->count();
        if ($cpfExistente >= 1) {
            return redirect(route('registro'))->with('Erro', 'CPF já cadastrado!');
        }

        $usuario = new Usuario();
        $usuario->nome = $request->nome;
        $usuario->telefone = $telefonelimpo;
        $usuario->cpf = $cpfNumeros;
        $usuario->email = $request->email;
        $usuario->senha = Hash::make($request->senha);
        $usuario->save();

        auth()->login($usuario);
        return redirect(route('index'));
    }

    public function registroadmin(Request $request)
    {
        // Função para validar CPF
        function validaCpf($cpf)
        {
            // Elimina possíveis máscaras
            $cpf = preg_replace('/\D/', '', $cpf);

            // Verifica se o número de dígitos é igual a 11
            if (strlen($cpf) != 11) {
                return false;
            }

            // Verifica se todos os dígitos são iguais (não é um CPF válido)
            if (preg_match('/(\d)\1{10}/', $cpf)) {
                return false;
            }

            // Calcula os dígitos verificadores
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf[$c] * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf[$c] != $d) {
                    return false;
                }
            }

            return true;
        }

        // Remove caracteres não numéricos do CPF
        $cpfNumeros = preg_replace('/\D/', '', $request->cpf);

        // Valida se o CPF é válido
        if (!validaCpf($cpfNumeros)) {
            return redirect(route('usuario.list'))->with('Erro', 'CPF inválido!');
        }

        // Verifica se o e-mail já existe
        $emailexiste = Usuario::where('email', $request->email)->count();
        if ($emailexiste >= 1) {
            return redirect(route('usuario.list'))->with('Erro', 'Email já existente!');
        }

        if ($request->senha != $request->confirma_senha) {
            return redirect(route('usuario.list'))->with('Erro', 'As senhas não são iguais!');
        }

        // Verifica se o e-mail já existe
        $telefoneexiste = Usuario::where('telefone', $request->telefone)->count();
        if ($telefoneexiste >= 1) {
            return redirect(route('usuario.list'))->with('Erro', 'Telefone já existente!');
        }

        // Verifica se o CPF já existe na tabela de usuários
        $cpfExistente = Usuario::where('cpf', $cpfNumeros)->count();
        if ($cpfExistente >= 1) {
            return redirect(route('usuario.list'))->with('Erro', 'CPF já cadastrado!');
        }

        $telefoneLimpo = preg_replace('/\D/', '', $request->telefone);

        // Cria um novo usuário
        $usuario = new Usuario();
        $usuario->nome = $request->nome;
        $usuario->telefone = $telefoneLimpo;
        $usuario->cpf = $cpfNumeros; // Armazena o CPF sem caracteres especiais
        $usuario->email = $request->email;
        $usuario->senha = Hash::make($request->senha);
        $usuario->func = true;

        if($request->admin == 'sim'){
            $usuario->admin = true;
        } else{
           $usuario->admin = false;
        }

        $usuario->save();

        return redirect(route('usuario.list'));
    }

    public function remover(Request $request, Usuario $usuario)
    {
        $usuario->delete();

        return redirect(route('usuario.list'));
    }

    public function edit(Request $request, Usuario $usuario)
    {
        return view('admin.usuarios.edit', ['usuario' => $usuario]);
    }

    public function update(Request $request, Usuario $usuario)
    {
        // Função para validar CPF
        function validaCpf($cpf)
        {
            // Elimina possíveis máscaras
            $cpf = preg_replace('/\D/', '', $cpf);

            // Verifica se o número de dígitos é igual a 11
            if (strlen($cpf) != 11) {
                return false;
            }

            // Verifica se todos os dígitos são iguais (não é um CPF válido)
            if (preg_match('/(\d)\1{10}/', $cpf)) {
                return false;
            }

            // Calcula os dígitos verificadores
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf[$c] * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf[$c] != $d) {
                    return false;
                }
            }

            return true;
        }

        // Remove caracteres não numéricos do CPF
        $cpfNumeros = preg_replace('/\D/', '', $request->cpf);

        // Remove caracteres não numéricos do CPF
        $telefonelimpo = preg_replace('/\D/', '', $request->telefone);

        // Valida se o CPF é válido
        if (!validaCpf($cpfNumeros)) {
            return redirect(route('usuario.list'))->with('Erro', 'CPF inválido!');
        }

        // Verifica se o e-mail já existe, exceto o do usuário atual
        $emailexiste = Usuario::where('email', $request->email)
            ->where('id', '!=', $usuario->id) // Ignora o usuário atual
            ->count();
        if ($emailexiste >= 1) {
            return redirect(route('usuario.list'))->with('Erro', 'Email já existente!');
        }

        // Verifica se o CPF já existe na tabela de usuários, exceto o do usuário atual
        $cpfExistente = Usuario::where('cpf', $cpfNumeros)
            ->where('id', '!=', $usuario->id) // Ignora o usuário atual
            ->count();
        if ($cpfExistente >= 1) {
            return redirect(route('usuario.list'))->with('Erro', 'CPF já cadastrado!');
        }

        $telefoneExistente = Usuario::where('telefone', $telefonelimpo)
            ->where('id', '!=', $usuario->id) // Ignora o usuário atual
            ->count();
        if ($telefoneExistente >= 1) {
            return redirect(route('usuario.list'))->with('Erro', 'Telefone já cadastrado!');
        }

        // Atualiza os dados do usuário
        $usuario->nome = $request->nome;
        $usuario->telefone = $telefonelimpo;
        $usuario->cpf = $cpfNumeros;
        $usuario->email = $request->email;

        if($request->admin == 'sim'){
            $usuario->admin = true;
        } else{
            $usuario->admin = false;
        }


        $usuario->save();

        return redirect(route('usuario.list'));
    }

    public function list(Request $request)
    {
        $usuarios = Usuario::all();

        return view('admin.usuarios.index', ['usuarios' => $usuarios]);
    }

    public function gerarPdf()
    {
        // Busca todos os usuários
        $usuarios = Usuario::all(); // Ajuste o modelo conforme necessário

        // Verifica se há usuários para incluir no relatório
        if ($usuarios->isEmpty()) {
            return redirect()->back()->with('error', 'Nenhum usuário encontrado para gerar o relatório.');
        }

        // Caminho da logo (ajuste conforme necessário)
        $logoPath = 'C:/Users/Dan/Documents/Projeto/pizzaria_ribeiro/public/site/img/logo.png';

        // Gera o conteúdo HTML do relatório
        $html = '
    <div style="text-align: center;">
        <img src="' . $logoPath . '" alt="Logo" style="width: 150px; height: auto; margin-bottom: 20px;">
        <h1>Relatório de Usuários</h1>
    </div>
    <table border="1" cellspacing="0" cellpadding="5" style="width: 100%; text-align: left; margin: 0 auto;">
        <thead>
            <tr>
                <th style="text-align: center;">Nome</th>
                <th style="text-align: center;">Email</th>
                <th style="text-align: center;">CPF</th>
                <th style="text-align: center;">Admin</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($usuarios as $usuario) {
            $html .= '<tr>';
            $html .= '<td style="text-align: center;">' . htmlspecialchars($usuario->nome) . '</td>'; // Centraliza o texto
            $html .= '<td style="text-align: center;">' . htmlspecialchars($usuario->email) . '</td>'; // Centraliza o texto
            $html .= '<td style="text-align: center;">' . $this->formataCpf($usuario->cpf) . '</td>'; // CPF formatado
            $html .= '<td style="text-align: center;">' . ($usuario->admin ? 'Sim' : 'Não') . '</td>'; // Verifica se é admin
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';

        // Gera o PDF usando mPDF
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        // Output do PDF para download
        return $mpdf->Output('relatorio_usuarios.pdf', 'D'); // 'D' para forçar download
    }

// Método para formatar CPF
    private function formataCpf($cpf)
    {
        return preg_replace('/^(\d{3})(\d{3})(\d{3})(\d{2})$/', '$1.$2.$3-$4', $cpf);
    }

}
