<!DOCTYPE html>
<html lang="pt-br">

@include('admin.components.headadmin', ['title'=>'Dashboard'])

<body>
<div class="container">

    @include('admin.components.sidebar')

    <!-- Main Content -->
    <div class="content">

        <div class="header">
            <div class="header-buttons">
                <span class="nav-item nav-link" style="font-size: 20px">Bem-Vindo, {{ auth()->user()->nome }}</span>
                <a href="{{ route('index') }}" class="btn">Retornar à Home</a>
                <a href="{{ route('logout') }}" class="btn">Logout</a>
            </div>
        </div>

        @if(auth()->user()->admin)
            <h1 style="text-align: center">Bem-vindo a área de administração da Pizzaria Ribeiro!</h1>
            <h2 style="text-align: center">Navegue pelas opções ao lado para o gerenciamento do sistema.</h2>
        <!-- Somatório Diário -->
        <div class="stats-container">
            <div class="lucro-diario">
                <h2>Somatório de pedidos do dia: R$ {{ number_format($lucroDiario, 2, ',', '.') }}</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-right mb-4">
                <button id="btn-diario" class="btn btn-primary btn-custom">
                    <i class="fas fa-chart-line"></i> Gráfico Diário
                </button>

                <button class="btn btn-success btn-custom" onclick="window.location='{{ route('dashboard.gerarPdf', 'diario') }}'">
                    <i class="fas fa-file-download"></i> Baixar PDF Diário
                </button>

                <button id="btn-semanal" class="btn btn-primary btn-custom">
                    <i class="fas fa-chart-bar"></i> Gráfico Semanal
                </button>

                <button class="btn btn-success btn-custom" onclick="window.location='{{ route('dashboard.gerarPdf', 'semanal') }}'">
                    <i class="fas fa-file-download"></i> Baixar PDF Semanal
                </button>

                <button id="btn-mensal" class="btn btn-primary btn-custom">
                    <i class="fas fa-calendar-alt"></i> Gráfico Mensal
                </button>

                <button class="btn btn-success btn-custom" onclick="window.location='{{ route('dashboard.gerarPdf', 'mensal') }}'">
                    <i class="fas fa-file-download"></i> Baixar PDF Mensal
                </button>
            </div>

        </div>
        @else
            <h1 style="text-align: center">Bem-vindo a área de administração da Pizzaria Ribeiro!</h1>
            <h2 style="text-align: center">Navegue pelas opções ao lado para o gerenciamento do sistema.</h2>
        @endif


        <div id="grafico-container" style="width: 100%; height: 400px;"></div>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

        <script type="text/javascript">
            // Carregar a biblioteca do Google Charts
            google.charts.load('current', {'packages':['corechart']});

            // Função para desenhar o gráfico
            function drawChart(graficoDados) {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Produto');
                data.addColumn('number', 'Quantidade');

                // Adiciona os dados ao gráfico
                graficoDados.forEach(function(item) {
                    data.addRow([item.produto, item.quantidade]);
                });

                // Configura opções do gráfico
                var options = {
                    title: 'Vendas de Produtos',
                    width: '100%',
                    height: 400,
                    backgroundColor: '#0f172b',
                    colors: ['#FA8032'],
                    titleTextStyle: {
                        color: '#FFFFFF' // Cor do título em branco
                    },
                    hAxis: {
                        textStyle: {
                            color: '#FFFFFF' // Cor do texto do eixo horizontal em branco
                        },
                        titleTextStyle: {
                            color: '#FFFFFF' // Cor do título do eixo horizontal em branco
                        }
                    },
                    vAxis: {
                        textStyle: {
                            color: '#FFFFFF' // Cor do texto do eixo vertical em branco
                        },
                        titleTextStyle: {
                            color: '#FFFFFF' // Cor do título do eixo vertical em branco
                        }
                    },
                    legend: {
                        textStyle: {
                            color: '#FFFFFF' // Cor do texto da legenda em branco
                        }
                    }
                };

                // Desenhar o gráfico
                var chart = new google.visualization.ColumnChart(document.getElementById('grafico-container'));
                chart.draw(data, options);
            }

            // Função para carregar os dados do gráfico
            function carregarGrafico(tipo) {
                let url;
                switch (tipo) {
                    case 'diario':
                        url = "{{ route('dashboard.grafico.diario') }}"; // Rota para gráfico diário
                        break;
                    case 'semanal':
                        url = "{{ route('dashboard.grafico.semanal') }}"; // Rota para gráfico semanal
                        break;
                    case 'mensal':
                        url = "{{ route('dashboard.grafico.mensal') }}"; // Rota para gráfico mensal
                        break;
                }

                // Fazer requisição AJAX para obter os dados
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        drawChart(data.graficoDados);
                    })
                    .catch(error => console.error('Erro ao carregar os dados do gráfico:', error));
            }

            // Event listeners para os botões
            document.getElementById('btn-diario').addEventListener('click', function() {
                carregarGrafico('diario');
            });

            document.getElementById('btn-semanal').addEventListener('click', function() {
                carregarGrafico('semanal');
            });

            document.getElementById('btn-mensal').addEventListener('click', function() {
                carregarGrafico('mensal');
            });
        </script>

    </div>
</div>
</body>
</html>
