<div class="sidebar">
    <!-- Logo -->
    <div class="logo-container">
        <img src="{{ asset('site/img/logo.png') }}" alt="Logo" class="logo">
    </div>

    <a href="{{ route('dashboard') }}">Dashboard</a>
    @if(auth()->user()->admin)
        <a href="{{ route('despesa.list') }}">Despesas</a>
        <a href="{{ route('usuario.list') }}">Usuários</a>
        <a href="{{ route('horario.list') }}">Horários</a>
        <a href="{{ route('categoria.list') }}">Categorias</a>
    @endif
    <a href="{{ route('produto.list') }}">Produtos</a>
    <a href="{{ route('adicional.list') }}">Adicionais</a>
    <a href="{{ route('pedido.list') }}">Pedidos</a>
    <a href="{{ route('cupom.list') }}">Cupons</a>
    <a href="{{ route('bairro.list') }}">Bairros</a>
</div>
