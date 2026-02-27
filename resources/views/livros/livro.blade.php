<x-layouts.layout title="ideas">

    <form method="GET" action="{{ route('livros.livro') }}" class="flex gap-3 items-center mb-6">
        <input name="q" value="{{ $q }}" class="input input-bordered w-full" placeholder="Pesquisar: nome do livro ou ISBN" />



        <select name="autor" class="select select-bordered">
            <option value="">Autor</option>
            @foreach ($autores as $autor)
                <option value="{{ $autor->id }}" @selected(request('autor') == $autor->id)>
                    {{ $autor->nome }}
                </option>
            @endforeach
        </select>

        <select name="editora" class="select select-bordered">
            <option value="">Editora</option>
            @foreach ($editoras as $editora)
                <option value="{{ $editora->id }}" @selected($editoraId == $editora->id)>{{ $editora->nome }}</option>
            @endforeach
        </select>

        <button class="btn btn-primary">Filtrar</button>

        <a href="{{ route('livros.livro') }}" class="btn btn-warning">Limpar</a>

        @if(auth()->check() && auth()->user()->id === 1)
            <a href="{{ route('livros.exportar.excel') }}" class="btn btn-success ">
                Exportar para Excel
            </a>
        @endif

    </form>

    <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($livros as $livro)
            @php
                $capaUrl = $livro->imagem_capa
                    ? \Illuminate\Support\Facades\Storage::url($livro->imagem_capa)
                    : asset('images/capa-default.jpg');
            @endphp

            <div class="card bg-base-100 shadow-sm border border-base-300">
                <figure class="px-4 pt-4">
                    <img
                        class="w-full h-43 object-cover rounded-xl"
                        src="{{ $capaUrl }}"
                        alt="{{ $livro->nome }}"
                        onerror="this.onerror=null;this.src='{{ asset('images/capa-default.jpg') }}';"
                    />
                </figure>

                <div class="card-body p-4 gap-2">
                    <h2 class="card-title text-base line-clamp-1">{{ $livro->nome }}</h2>

                    <p class="text-sm text-base-content/70 leading-5">
                        <span class="font-medium">Autor(es):</span> {{ $livro->autores->pluck('nome')->join(', ') ?: '—' }}
                    </p>
                    <p class="text-sm text-base-content/70 leading-5">
                        <span class="font-medium">Editora:</span> {{ $livro->editora?->nome ?? '—' }}<br>
                    </p>


                    <div class="card-actions justify-end pt-2">
                        <a href="{{ route('livros.show', $livro) }}" class="btn btn-primary btn-sm">
                            Ver Mais
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-base-content/70">Nenhum livro encontrado.</p>
        @endforelse
    </div>

    @if ($livros->hasPages())
        <div class="flex justify-center mt-6">
            <div class="join">
                {{-- Previous --}}
                @if ($livros->onFirstPage())
                    <button class="join-item btn btn-outline btn-disabled">Previous page</button>
                @else
                    <a class="join-item btn btn-outline" href="{{ $livros->previousPageUrl() }}">Previous page</a>
                @endif

                {{-- Next --}}
                @if ($livros->hasMorePages())
                    <a class="join-item btn btn-outline" href="{{ $livros->nextPageUrl() }}">Next</a>
                @else
                    <button class="join-item btn btn-outline btn-disabled">Next</button>
                @endif
            </div>
        </div>
    @endif

</x-layouts.layout>
