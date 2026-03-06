<x-layouts.layout title="Editar: {{ $livro->nome }}">

    @can('ViewAdicionar')

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

                <div class="w-full max-w-2xl">
                    <h1 class="text-4xl font-bold mb-6">Editar Livro</h1>

                    {{-- EDIT FORM --}}
                    <form method="POST" action="{{ route('livros.update', $livro->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="grid gap-4">

                            <div>
                                <label class="label"><span class="label-text font-semibold">Nome</span></label>
                                <input type="text" name="nome" class="input input-bordered w-full"
                                       value="{{ old('nome', $livro->nome) }}" />
                                <x-forms.error name="nome" />
                            </div>

                            <div>
                                <label class="label"><span class="label-text font-semibold">ISBN</span></label>
                                <input type="text" name="isbn" class="input input-bordered w-full"
                                       value="{{ old('isbn', $livro->isbn) }}" />
                                <x-forms.error name="isbn" />
                            </div>

                            <div>
                                <label class="label" for="autor_id"><span class="label-text font-semibold">Autor</span></label>
                                <select name="autor_id" class="select select-bordered" required>
                                    <option value="{{old('autor', $livro->autor)}}">Selecione o autor</option>
                                    @foreach($autores as $autor)
                                        <option value="{{ $autor->id }}" {{ old('autor_id') == $autor->id ? 'selected' : '' }}>
                                            {{ $autor->nome }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-forms.error name="autor_id" />
                            </div>

                            <div>
                                <label class="label" for="editoras_id">Editora</label>
                                <select name="editoras_id" class="select select-bordered" required>
                                    <option value="{{old('editora', $livro->editora)}}">Selecione a editora</option>
                                    @foreach ($editoras as $editora)
                                        <option value="{{ $editora->id }}">{{ $editora->nome }}</option>
                                    @endforeach
                                </select>
                                <x-forms.error name="editoras_id" />
                            </div>


                            <div>
                                <label class="label"><span class="label-text font-semibold">Bibliografia</span></label>
                                <textarea name="bibliografia" rows="3"
                                          class="textarea textarea-bordered w-full">{{ old('bibliografia', $livro->bibliografia) }}</textarea>
                                <x-forms.error name="bibliografia" />
                            </div>

                            <div>
                                <label class="label"><span class="label-text font-semibold">Preço (€)</span></label>
                                <input type="number" step="0.01" name="preco" class="input input-bordered w-full"
                                       value="{{ old('preco', $livro->preco) }}" />
                                <x-forms.error name="preco" />
                            </div>

                            <div>
                                <label class="label"><span class="label-text font-semibold">Imagem de capa (opcional)</span></label>
                                <input type="file" name="imagem_capa" class="file-input file-input-bordered w-full" />
                                <x-forms.error name="imagem_capa" />
                            </div>

                            <div class="flex gap-3 pt-2">
                                <a href="{{ route('livros.livro') }}" class="btn btn-primary">Voltar</a>

                                <button type="submit" class="btn btn-success">
                                    Guardar Alterações
                                </button>

                                <button
                                    type="submit"
                                    form="delete-livro-form"
                                    class="btn btn-error"
                                    onclick="return confirm('Tem certeza que deseja apagar este livro?');"
                                >
                                    Apagar Livro
                                </button>
                            </div>

                        </div>
                    </form>

                    {{-- DELETE FORM --}}
                    <form id="delete-livro-form" method="POST" action="{{ route('livros.destroy', $livro->id) }}">
                        @csrf
                        @method('DELETE')
                    </form>

                </div>
            </div>
        </div>

    @else
        <div class="p-6">
            <div class="alert alert-error">Acesso negado.</div>
        </div>
    @endcan

</x-layouts.layout>
