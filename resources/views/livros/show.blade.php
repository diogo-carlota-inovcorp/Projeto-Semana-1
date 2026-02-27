<x-layouts.layout title="{{ $livro->nome }}">

    @php
        $capaUrl = $livro->imagem_capa
            ? \Illuminate\Support\Facades\Storage::url($livro->imagem_capa)
            : asset('images/capa-default.jpg');
    @endphp

    <div class="bg-base-200 py-12">
        <div class="hero-content flex-col lg:flex-row gap-8">

            <img
                src="{{ $capaUrl }}"
                class="max-w-xs w-full rounded-lg shadow-2xl object-cover"
                alt="{{ $livro->nome }}"
                onerror="this.onerror=null;this.src='{{ asset('images/capa-default.jpg') }}';"
            />

            <div>
                <h1 class="text-4xl font-bold mb-2">{{ $livro->nome }}</h1>

                <p class="py-4 text-base-content/80 leading-relaxed">
                    <span class="font-semibold">ISBN:</span> {{ $livro->isbn }} <br>
                    <span class="font-semibold">Editora:</span> {{ $livro->editora?->nome ?? '—' }} <br>
                    <span class="font-semibold">Autor(es):</span> {{ $livro->autores->pluck('nome')->join(', ') ?: '—' }} <br>
                    <span class="font-semibold">Bibliografia:</span> {{ $livro->bibliografia }} <br>
                    <span class="font-semibold">Preço:</span> {{ $livro->preco }} € <br>
                </p>

                {{-- If you have description --}}
                @if($livro->descricao)
                    <p class="mb-6">
                        <span class="font-semibold">Descrição:</span><br>
                        {{ $livro->descricao }}
                    </p>
                @endif

                <div class="flex gap-3">
                    <a href="{{ route('livros.livro') }}" class="btn btn-primary">
                        Voltar
                    </a>

                    {{-- ADMIN ONLY DELETE --}}
                    @auth
                        @if(auth()->user()->ViewAdicionar)
                            <form method="POST" action="{{ route('livros.destroy', $livro) }}"
                                  onsubmit="return confirm('Tem certeza que deseja apagar este livro?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-error">
                                    Apagar Livro
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>

            </div>
        </div>
    </div>

</x-layouts.layout>
