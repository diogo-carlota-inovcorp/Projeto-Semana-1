<x-layouts.layout title="Autores">

    <div class="max-w-4xl mx-auto">
        <form method="GET" action="{{ route('livros.autor') }}" class="max-w-4xl mx-auto flex gap-2 mb-6">
            <input
                name="q"
                value="{{ request('q') }}"
                class="input input-bordered w-full"
                placeholder="Pesquisar: Nome do Autor"
            />

            <button class="btn btn-primary">Filtrar</button>

            <a href="{{ route('livros.autor') }}" class="btn btn-warning">Limpar</a>
        </form>

        <div class="overflow-x-auto">
            <table class="table w-full">
            <thead>
            <tr>
                <th>Foto</th>
                <th>Nome</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            @forelse($autores as $autor)
                @php
                    $fotoUrl = $autor->foto
                        ? \Illuminate\Support\Facades\Storage::disk('public')->url($autor->foto)
                        : asset('images/autor-default.jpg');
                @endphp

                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="avatar">
                                <div>
                                    <img
                                        src="{{ $fotoUrl }}"
                                        alt="Foto de {{ $autor->nome }}"
                                        class="h-12 w-12 object-cover rounded-lg"
                                        onerror="this.onerror=null;this.src='{{ asset('images/autor-default.jpg') }}';"
                                    />
                                </div>
                            </div>
                        </div>
                    </td>

                    <td>
                        {{ $autor->nome }}
                    </td>

                    <td class="text-right">
                        <a
                            href="{{ route('livros.livro', ['autor' => $autor->id]) }}"
                            class="btn btn-primary btn-sm"
                        >
                            Ver livros
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-base-content/70">
                        Nenhum autor encontrado.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    </div>

    @if ($autores->hasPages())
        <div class="flex justify-center mt-6">
            <div class="join">
                {{-- Previous --}}
                @if ($autores->onFirstPage())
                    <button class="join-item btn btn-outline btn-disabled">Página anterior</button>
                @else
                    <a class="join-item btn btn-outline" href="{{ $autores->previousPageUrl() }}">Página anterior</a>
                @endif

                {{-- Next --}}
                @if ($autores->hasMorePages())
                    <a class="join-item btn btn-outline" href="{{ $autores->nextPageUrl() }}">Próxima</a>
                @else
                    <button class="join-item btn btn-outline btn-disabled">Próxima</button>
                @endif
            </div>
        </div>
    @endif

</x-layouts.layout>
