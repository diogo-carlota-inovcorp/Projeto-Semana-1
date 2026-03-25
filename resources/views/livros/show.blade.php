<x-layouts.layout title="{{ $livro->nome }}">

    @php
        $capaUrl = $livro->imagem_capa
            ? \Illuminate\Support\Facades\Storage::url($livro->imagem_capa)
            : asset('images/capa-default.jpg');
    @endphp

    <div class="bg-base-200 py-12">
        <div class="hero-content flex-col lg:flex-row gap-8">

            <img
                src="{{ $livro->imagem_capa ? str_replace('http://', 'https://', $livro->imagem_capa) : asset('images/capa-default.jpg') }}"
                alt="{{ $livro->nome }}"
                class="w-full h-full object-cover rounded-t-lg"
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

                    <form method="POST" action="{{ route('cart.add', $livro) }}">
                        @csrf
                        <button class="btn btn-success">
                            Comprar
                        </button>
                    </form>

                    @can('ViewAdicionar')
                        <a href="{{ route('livros.edit', $livro->id) }}" class="btn btn-primary">
                            Editar
                        </a>
                    @endcan
                </div>

            </div>
        </div>
    </div>
    <hr class="my-8 opacity-20">

    <h2 class="text-xl font-bold mb-4">Histórico de Requisições</h2>

    @if($livro->requisicoes->isEmpty())
        <div class="alert alert-info">Este livro ainda não foi requisitado.</div>
    @else
        <div class="overflow-x-auto bg-base-200 rounded-lg">
            <table class="table">
                <thead>
                <tr>
                    <th>Cidadão</th>
                    <th>Status</th>
                    <th>Requisitado</th>
                    <th>Previsto</th>
                </tr>
                </thead>
                <tbody>
                @foreach($livro->requisicoes as $r)
                    <tr>
                        <td>{{ $r->user->name ?? $r->user->nome ?? '—' }}</td>
                        <td><span class="badge">{{ $r->status }}</span></td>
                        <td>{{ optional($r->requisitado_em)->format('d/m/Y H:i') }}</td>
                        <td>{{ optional($r->fim_previsto)->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="mt-10">
        <h2 class="text-2xl font-bold mb-4">Reviews</h2>

        <div class="mb-6">
            @if($totalReviews > 0)
                <div class="flex items-center gap-3">
                <span class="text-xl font-semibold">
                    Média: {{ number_format($mediaReviews, 1) }}/5
                </span>
                    <span class="text-base-content/70">
                    ({{ $totalReviews }} review{{ $totalReviews > 1 ? 's' : '' }})
                </span>
                </div>
            @else
                <p class="text-base-content/70">Ainda não existem reviews ativas para este livro.</p>
            @endif
        </div>



        @forelse($reviewsAtivas as $review)
            <div class="card bg-base-100 shadow mb-4">
                <div class="card-body">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-semibold">{{ $review->user->name }}</h3>
                        <span class="badge badge-primary">{{ $review->rating }}/5</span>
                    </div>

                    <p>{{ $review->comentario }}</p>
                    <p class="text-sm text-base-content/60 mt-2">
                        {{ $review->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>
        @empty
        @endforelse

        @if($relacionados->count())
            <div class="mt-10">
                <h2 class="text-2xl font-bold mb-4">Livros Relacionados</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($relacionados as $relacionado)
                        <div class="card bg-base-100 shadow">
                            <div class="card-body">
                                <h3 class="card-title">{{ $relacionado->nome }}</h3>

                                @if($relacionado->autores->count())
                                    <p class="text-sm text-base-content/70">
                                        {{ $relacionado->autores->pluck('nome')->join(', ') }}
                                    </p>
                                @endif

                                <p class="text-sm">
                                    {{ \Illuminate\Support\Str::limit($relacionado->bibliografia, 120) }}
                                </p>

                                <div class="card-actions justify-end">
                                    <a href="{{ route('livros.show', $relacionado->id) }}" class="btn btn-primary btn-sm">
                                        Ver detalhe
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

</x-layouts.layout>
