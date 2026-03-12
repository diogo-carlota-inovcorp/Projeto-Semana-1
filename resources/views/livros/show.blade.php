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

</x-layouts.layout>
