<x-layouts.layout title="Resultados da Pesquisa">
    <div class="max-w-7xl mx-auto">
        @if(session('success'))
            <div class="alert alert-success mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Resultados para "{{ $query }}"</h1>
            <a href="{{ route('google-books.index') }}" class="btn btn-ghost">Nova Pesquisa</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($books as $book)
                <div class="card bg-base-100 shadow-xl card-side">
                    <figure class="w-40 h-auto flex-shrink-0">
                        <img
                            src="{{ $book['capa_thumbnail'] ?: asset('images/capa-default.jpg') }}"
                            alt="{{ $book['titulo'] }}"
                            class="object-cover w-full h-full"
                            onerror="this.onerror=null;this.src='{{ asset('images/capa-default.jpg') }}';"
                        >
                    </figure>

                    <div class="card-body">
                        <h2 class="card-title text-base">{{ $book['titulo'] }}</h2>
                        <p class="text-sm"><strong>Autor(es):</strong> {{ implode(', ', $book['autores']) }}</p>
                        <p class="text-sm"><strong>Editora:</strong> {{ $book['editora'] }}</p>
                        <p class="text-sm"><strong>ISBN:</strong> {{ $book['isbn'] ?? 'N/A' }}</p>

                        <div class="card-actions justify-end mt-2">
                            <form action="{{ route('google-books.import') }}" method="POST">
                                @csrf
                                <input type="hidden" name="titulo" value="{{ $book['titulo'] }}">
                                <input type="hidden" name="autores" value="{{ implode(',', $book['autores']) }}">
                                <input type="hidden" name="editora" value="{{ $book['editora'] }}">
                                <input type="hidden" name="descricao" value="{{ $book['descricao'] }}">
                                <input type="hidden" name="isbn" value="{{ $book['isbn'] }}">
                                <input type="hidden" name="imagem_capa" value="{{ $book['capa_thumbnail'] ?? '' }}">
                                <button type="submit" class="btn btn-xs btn-success">Importar</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <p class="text-base-content/60">Nenhum livro encontrado. Tenta outra pesquisa.</p>
                </div>
            @endforelse
        </div>
    </div>
    <div class="flex justify-center gap-4 mt-8">
        @if($hasPreviousPage)
            <a href="{{ route('google-books.search', ['query' => $query, 'page' => $page - 1]) }}"
               class="btn btn-outline">
                Anterior
            </a>
        @endif

        <span class="btn btn-ghost pointer-events-none">
        Página {{ $page }}
    </span>

        @if($hasNextPage)
            <a href="{{ route('google-books.search', ['query' => $query, 'page' => $page + 1]) }}"
               class="btn btn-outline">
                Seguinte
            </a>
        @endif
    </div>
</x-layouts.layout>
