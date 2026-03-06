<x-layouts.layout title="Requisições">

    <div class="p-6 space-y-5">

        <div class="flex flex-col gap-2">
            <h1 class="text-3xl font-bold">Requisições</h1>

            <div class="stats shadow bg-base-200">
                <div class="stat">
                    <div class="stat-title">Requisições Ativas</div>
                    <div class="stat-value text-xl">{{ $ativas }}</div>
                </div>
                <div class="stat">
                    <div class="stat-title">Últimos 30 dias</div>
                    <div class="stat-value text-xl">{{ $ultimos30 }}</div>
                </div>
                <div class="stat">
                    <div class="stat-title">Livros entregues hoje</div>
                    <div class="stat-value text-xl">{{ $entreguesHoje }}</div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif
        </div>

        <form method="GET" action="{{ route('requisicoes.index') }}" class="flex gap-2">
            <input
                class="input input-bordered w-full max-w-md"
                name="q"
                value="{{ $q }}"
                placeholder="Pesquisar por nome ou ISBN..."
            />
            <button class="btn btn-primary">Pesquisar</button>
            <a class="btn btn-secondary" href="{{ route('requisicoes.minhas') }}" > Ver requisições</a>
            @if($q)
                <a class="btn btn-ghost" href="{{ route('requisicoes.index') }}">Limpar</a>
            @endif
        </form>

        @auth
            @if((auth()->user()->role ?? null) === 'admin')
                <div class="bg-base-200 rounded-lg p-4">
                    <h2 class="text-xl font-bold mb-3">Devoluções por Confirmar</h2>

                    @if($porConfirmar->isEmpty())
                        <div class="alert alert-info">Sem devoluções por confirmar.</div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Livro</th>
                                    <th>Cidadão</th>
                                    <th>Pedido em</th>
                                    <th class="text-right">Ação</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($porConfirmar as $r)
                                    <tr>
                                        <td class="font-semibold">{{ $r->livro->nome }}</td>
                                        <td>{{ $r->user->nome ?? $r->user->name }}</td>
                                        <td>{{ optional($r->updated_at)->format('d/m/Y H:i') }}</td>
                                        <td class="text-right">
                                            <form method="POST" action="{{ route('admin.requisicoes.confirmarDevolucao', $r) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn btn-sm btn-warning"
                                                        onclick="return confirm('Confirmar devolução deste livro?');">
                                                    Confirmar devolução
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            @endif
        @endauth

        <div class="overflow-x-auto bg-base-200 rounded-lg">
            <table class="table">
                <thead>
                <tr>
                    <th>Livro</th>
                    <th>ISBN</th>
                    <th>Estado</th>
                    <th class="text-right">Ação</th>
                </tr>
                </thead>
                <tbody>
                @forelse($livros as $livro)
                    @php $disponivel = ($livro->requisicoes_ativas_count == 0); @endphp

                    <tr>
                        <td class="font-semibold">{{ $livro->nome }}</td>
                        <td>{{ $livro->isbn }}</td>
                        <td>
                            @if($disponivel)
                                <span class="badge badge-success">Disponível</span>
                            @else
                                <span class="badge badge-error">Indisponível</span>
                            @endif
                        </td>
                        <td class="text-right">
                            @if($disponivel)
                                <form method="POST" action="{{ route('requisicoes.store') }}">
                                    @csrf
                                    <input type="hidden" name="livro_id" value="{{ $livro->id }}">
                                    <button class="btn btn-sm btn-success"
                                            onclick="return confirm('Requisitar este livro?')">
                                        Requisitar
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-sm btn-disabled">Requisitar</button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4">Sem livros.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $livros->links() }}
    </div>

</x-layouts.layout>
