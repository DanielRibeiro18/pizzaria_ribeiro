<div class="sidebar">
    <!-- Logo -->
    <div class="logo-container">
        <img src="{{ asset('site/img/logo.png') }}" alt="Logo" class="logo">
    </div>

    <a href="{{ route('dashboard') }}">Dashboard</a>
    <a href="{{ route('produto.list') }}">Produtos</a>
    <a href="{{ route('adicional.list') }}">Adicionais</a>
    <a href="{{ route('usuario.list') }}">Usuários</a>
    <a href="{{ route('pedido.list') }}">Pedidos</a>
    <a href="{{ route('horario.list') }}">Horários</a>
    <a href="#">Categorias</a>
    <a href="#">Cupons</a>
</div>
