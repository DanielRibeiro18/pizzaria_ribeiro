<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #0f172b;
            color: #fff;
        }

        .dashboard-container {
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #1e293b;
            padding: 20px;
            box-sizing: border-box;
        }

        .sidebar a {
            display: block;
            color: #fff;
            text-decoration: none;
            padding: 15px;
            font-size: 18px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .sidebar a:hover {
            background-color: #FA8032;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: flex-end; /* Alinha os itens à direita */
            align-items: center; /* Alinha verticalmente no centro */
            padding: 10px;
            background-color: #0f172b; /* Cor do fundo */
            position: relative; /* Permite o posicionamento absoluto */
            z-index: 1; /* Garante que a barra de navegação não sobreponha */
        }

        .header-buttons {
            display: flex;
            gap: 10px; /* Espaçamento entre os botões */
        }

        .header .btn {
            background-color: #FA8032; /* Cor primária */
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .header .btn:hover {
            background-color: #e98e3c; /* Cor ao passar o mouse */
        }

        .nav-item {
            color: white; /* Alinha a cor do texto com a cor do botão */
        }

        .stats-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .stat-card {
            background-color: #1e293b;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
        }

        .stat-card h3 {
            font-size: 18px;
            color: #FA8032;
            margin-bottom: 10px;
        }

        .stat-card p {
            font-size: 24px;
            font-weight: bold;
        }

        #chart_div {
            width: 100%;
            height: 400px;
        }

        .sidebar .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar .logo {
            width: 100px;
            height: 100px;
            object-fit: contain;
        }

        .lucro-diario {
            background-color: #FA8032; /* Cor do fundo */
            color: white; /* Cor do texto */
            padding: 20px;
            border-radius: 5px;
            margin: 20px; /* Adiciona uma margem ao redor */
            text-align: center; /* Centraliza o texto */
        }



    </style>
</head>
<body>
<div class="dashboard-container">



    <div class="sidebar">
        <!-- Logo -->
        <div class="logo-container">
            <img src="{{ asset('site/img/logo.png') }}" alt="Logo" class="logo">
        </div>

        <!-- Links da Sidebar -->
        <a href="#">Dashboard</a>
        <a href="#">Produtos</a>
        <a href="{{ route('adicional.list') }}">Adicionais</a>
        <a href="{{ route('usuario.list') }}">Usuários</a>
        <a href="#">Pedidos</a>
        <a href="#">Bairros</a>
        <a href="{{ route('horario.list') }}">Horários</a>
        <a href="#">Categorias</a>
        <a href="#">Cupons</a>
    </div>




    <!-- Main Content -->
    <div class="content">

        <div class="header">
            <div class="header-buttons">
                <span class="nav-item nav-link" style="font-size: 20px">Bem-Vindo, {{ auth()->user()->nome }}</span>
                <a href="{{ route('index') }}" class="btn">Retornar à Home</a>
                <a href="{{ route('logout') }}" class="btn">Logout</a>
            </div>
        </div>

        <!-- Lucro Diário -->
        <div class="stats-container">
            <div class="lucro-diario">
                <h2>Lucro Diário: R$ {{ number_format($lucroDiario, 2, ',', '.') }}</h2>
            </div>
        </div>

        <div>

            <h2>Pedidos</h2>
            <ul>
                @foreach($pedidos as $pedido)
                    <li>Pedido #{{ $pedido->id }} - Total: R$ {{ $pedido->subtotal }}</li>
                @endforeach
            </ul>

            <h2>Produtos</h2>
            <ul>
                @foreach($produtos as $produto)
                    <li>{{ $produto->nome }} - Preço: R$ {{ $produto->preco }}</li>
                @endforeach
            </ul>

            <h2>Usuários</h2>
            <ul>
                @foreach($usuarios as $usuario)
                    <li>{{ $usuario->nome }} - Email: {{ $usuario->email }}</li>
                @endforeach
            </ul>
        </div>


        <!-- Gráfico de Colunas -->
        <div id="chart_div"></div>
    </div>
</div>

<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Dia', 'Lucro'],
            ['Seg', 1000],
            ['Ter', 1170],
            ['Qua', 660],
            ['Qui', 1030],
            ['Sex', 1200],
            ['Sáb', 1500],
            ['Dom', 1400]
        ]);

        var options = {
            title: 'Lucro Diário',
            backgroundColor: '#0f172b',
            titleTextStyle: {color: '#FA8032', fontSize: 18},
            legend: {position: 'none'},
            hAxis: {
                textStyle: {color: '#fff'}
            },
            vAxis: {
                textStyle: {color: '#fff'}
            },
            colors: ['#FA8032'],
            chartArea: {width: '80%', height: '70%'}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }

</script>
</body>
</html>
