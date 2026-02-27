@php
    use Illuminate\Support\Facades\Storage;

    // função inline para gerar a URL correta independente do que está guardado na BD
    $coverUrl = function ($path) {
        if (!$path) return asset('images/no-cover.png');

        // Se já for uma URL completa (http/https), devolve como está
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // Se vier "storage/capas/xxx.jpg", remove o "storage/"
        $path = preg_replace('#^storage/#', '', $path);

        // Gera /storage/... usando o disk "public"
        return Storage::url($path);
    };
@endphp

<x-layouts.layout title="index">

    <div class="text-center">
        <h3 class="text-4xl md:text-5xl font-bold mb-2">
            Bem vindo à nossa biblioteca
        </h3>
        <p class="text-lg md:text-xl text-base-content/80">
            Faça login e encontre tudo o que oferecemos
        </p>
    </div>

    <div class="container mx-auto px-6 py-16">

        <div class="grid grid-cols-12 gap-8 items-center">
            <div class="col-span-12 flex justify-center gap-10">

                @forelse(($livros ?? collect())->take(3) as $i => $livro)
                    <div class="hover-3d {{ $i === 1 ? 'scale-110' : '' }}">
                        <figure class="w-60 h-80 rounded-2xl overflow-hidden">
                            <img
                                src="{{ $coverUrl($livro->imagem_capa) }}"
                                alt="{{ $livro->titulo }}"
                                class="w-full h-full object-cover"
                                loading="lazy"
                                onerror="this.src='{{ asset('images/no-cover.png') }}'"
                            />
                        </figure>
                        <div></div><div></div><div></div><div></div>
                        <div></div><div></div><div></div><div></div>
                    </div>
                @empty
                    <div class="text-center opacity-70">
                        Nenhum livro encontrado.
                    </div>
                @endforelse

            </div>
        </div>


        <div class="mt-20 flex justify-center gap-12">

            <div class="card w-96 bg-base-200 card-md shadow-sm">
                <div class="card-body items-center text-center gap-6">
                    <h2 class="card-title text-xl">Ver Livros</h2>
                    <span class="text-center font-bold">Visite esta página para ver os nossos livros e informações!</span>
                    <a href="{{ route('livros.livro') }}"  class="btn btn-success btn-soft mt-4">Visitar Página</a>
                </div>
            </div>

            <div class="card w-96 bg-base-200 card-md shadow-sm">
                <div class="card-body items-center text-center gap-6">
                    <h2 class="card-title text-xl">Ver Editoras</h2>
                    <span class="text-center font-bold">Visite esta página para saber mais sobre as nossas editoras!</span>
                    <a href="{{ route('livros.editora') }}" class="btn btn-success btn-soft mt-4">Visitar Página</a>
                </div>
            </div>

            <div class="card w-96 bg-base-200 card-md shadow-sm">
                <div class="card-body items-center text-center gap-6">
                    <h2 class="card-title text-xl">Ver Autores</h2>
                    <span class="text-center font-bold">Visite esta página para saber mais sobre os autores que temos!</span>
                    <a  href="{{ route('livros.autor') }}"   class="btn btn-success btn-soft mt-4">Visitar Página</a>
                </div>
            </div>

        </div>
    </div>
</x-layouts.layout>
