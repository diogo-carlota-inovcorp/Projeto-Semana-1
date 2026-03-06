<x-layouts.layout>

    <h1>As Minhas Requisições</h1>

    @foreach($requisicoes as $req)
        <div class="card mb-4 p-4 bg-base-200">
            <h2>{{ $req->livro->nome }}</h2>
            <p>Data requisição: {{ $req->requisitado_em }}</p>
            <p>Entrega prevista: {{ $req->fim_previsto }}</p>

            <form method="POST" action="{{ route('requisicoes.pedirDevolucao', $req) }}">
                @csrf
                @method('PATCH')
                <button class="btn btn-success"
                        onclick="return confirm('Enviar pedido de devolução?');">
                    Entregar Livro
                </button>
            </form>
        </div>
    @endforeach

</x-layouts.layout>
