<x-layouts.layout title="Editoras">

    <div class="max-w-4xl mx-auto">
        <form method="GET" action="{{ route('livros.editora') }}" class="max-w-4xl mx-auto flex gap-2 mb-6">
            <input
                name="q"
                value="{{ request('q') }}"
                class="input input-bordered w-full"
                placeholder="Pesquisar: Nome da Editora"
            />

            <button class="btn btn-primary">Filtrar</button>

            <a href="{{ route('livros.editora') }}" class="btn btn-warning">Limpar</a>
        </form>

        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                <tr>
                    <th>Logo</th>
                    <th>Nome</th>
                    <th class="text-right">Ações</th>
                </tr>
                </thead>

                <tbody>
                @forelse($editoras as $editora)
                    @php
                        $logoUrl = $editora->logo
                            ? \Illuminate\Support\Facades\Storage::url($editora->logo)
                            : asset('images/logo-default.jpg');
                    @endphp

                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="avatar">
                                    <div>
                                        <img
                                            src="{{ $logoUrl }}"
                                            alt="Foto de {{ $editora->nome }}"
                                            class="h-12 w-12 object-cover rounded-lg"
                                            onerror="this.onerror=null;this.src='{{ asset('images/editora-default.png') }}';"
                                        />
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            {{ $editora->nome }}
                        </td>

                        <td class="text-right">
                            <div class="flex justify-end gap-2">
                                <a
                                    href="{{ route('livros.editar_editora', $editora->id) }}"
                                    class="btn btn-secondary btn-sm"
                                >
                                    Editar
                                </a>

                                <a
                                    href="{{ route('livros.livro', ['editora' => $editora->id]) }}"
                                    class="btn btn-primary btn-sm"
                                >
                                    Ver livros
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-base-content/70">
                            Nenhuma Editora encontrada.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($editoras->hasPages())
        <div class="flex justify-center mt-6">
            <div class="join">
                @if ($editoras->onFirstPage())
                    <button class="join-item btn btn-outline btn-disabled">Página anterior</button>
                @else
                    <a class="join-item btn btn-outline" href="{{ $editoras->previousPageUrl() }}">Página anterior</a>
                @endif

                @if ($editoras->hasMorePages())
                    <a class="join-item btn btn-outline" href="{{ $editoras->nextPageUrl() }}">Próxima</a>
                @else
                    <button class="join-item btn btn-outline btn-disabled">Próxima</button>
                @endif
            </div>
        </div>
    @endif

</x-layouts.layout>
