
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}} - Pizzaria Ribeiro</title>

    <!-- Favicon -->
    <link href="site/img/pizzaria-logo.ico" rel="icon">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #0f172b;
            color: #fff;
        }

        .container {
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

        .btn-custom {
            margin-left: 10px;
            padding: 10px 20px;
            font-size: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px; /* Espaço entre o ícone e o texto */
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-custom i {
            font-size: 18px;
        }

        /* Estilização no hover para melhorar a usabilidade */
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .btn-success:hover {
            background-color: #FA8032;
            border-color: #ea7931;
        }

    </style>
</head>
