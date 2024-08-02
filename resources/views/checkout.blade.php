@foreach($produtos as $produto)
    {{ $produto->nome }}
    {{ $produto->tamanho }}
@endforeach
