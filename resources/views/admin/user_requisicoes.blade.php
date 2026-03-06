<x-layouts.layout title="Requisições de {{ $user->name ?? $user->nome }}">

    <div class="container mx-auto py-8">

        <h1 class="text-2xl font-bold mb-6">
            Requisições de {{ $user->name ?? $user->nome }}
        </h1>

        @if($requisicoes->isEmpty())
            <div class="alert alert-info">
                Este utilizador não tem requisições.
            </div>
        @else

            <table class="table w-full bg-base-200 rounded-lg">
                <thead>
                <tr>
                    <th>Livro</th>
                    <th>Status</th>
                    <th>Requisitado em</th>
                    <th>Entrega prevista</th>
                    <th>Detalhes</th>
                </tr>
                </thead>
                <tbody>
                @foreach($requisicoes as $req)
                    <tr>
                        <td>{{ $req->livro->nome }}</td>
                        <td>{{ $req->status }}</td>
                        <td>{{ $req->requisitado_em }}</td>
                        <td>{{ $req->fim_previsto }}</td>
                        <td>
                            <a href="{{ route('requisicoes.show', $req) }}" class="btn btn-sm btn-primary">
                                Ver Detalhes
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        @endif

    </div>

</x-layouts.layout>
