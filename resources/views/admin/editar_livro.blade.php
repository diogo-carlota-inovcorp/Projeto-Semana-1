<x-layouts.layout>

        <form method="POST" action="/livros/{{ $livro->id }}">
            @csrf
            @method('PATCH')

            <div class="col-span-full">
                <label for="description" class="block text-sm/6 font-medium text-white">
                    Editar livro
                </label>

                <div class="mt-2">
                    <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4 mx-auto">
                        <legend class="fieldset-legend">Adicionar Livro</legend>

                        <label class="label" for="isbn">ISBN</label>
                        <input type="text" name="isbn" class="input" placeholder="ISBN do livro" required />
                        <x-forms.error name="isbn" />

                        <label class="label" for="nome">Nome</label>
                        <input type="text" name="nome" class="input" placeholder="Nome do livro" required />
                        <x-forms.error name="nome" />

                        <label class="label" for="editoras_id">Editora</label>
                        <select name="editoras_id" class="select select-bordered" required>
                            <option value="">Selecione a editora</option>
                            @foreach ($editoras as $editora)
                                <option value="{{ $editora->id }}">{{ $editora->nome }}</option>
                            @endforeach
                        </select>
                        <x-forms.error name="editoras_id" />

                        <label class="label" for="autor_id">Autor</label>
                        <select name="autor_id" class="select select-bordered" required>
                            <option value="">Selecione o autor</option>
                            @foreach($autores as $autor)
                                <option value="{{ $autor->id }}" {{ old('autor_id') == $autor->id ? 'selected' : '' }}>
                                    {{ $autor->nome }}
                                </option>
                            @endforeach
                        </select>
                        <x-forms.error name="autor_id" />

                        <x-forms.error name="autor_ids" />
                        <x-forms.error name="autor_ids.*" />
                        <label class="label" for="bibliografia">Bibliografia</label>
                        <textarea name="bibliografia" class="textarea textarea-bordered" placeholder="Bibliografia do livro"></textarea>
                        <x-forms.error name="bibliografia" />

                        <label class="label" for="preco">Preço</label>
                        <input type="number" step="0.01" name="preco" class="input" placeholder="Preço" required />
                        <x-forms.error name="preco" />

                        <input type="file" name="imagem_capa" class="file-input file-input-bordered" accept="image/*" />
                        <x-forms.error name="imagem_capa" />

                        <button class="btn btn-neutral mt-4 w-full">Adicionar Livro</button>
                    </fieldset>

                    <x-forms.error name="description" />
                </div>

                <div class="mt-6 flex items-center gap-x-2">


                    <button type="submit" class="btn btn-primary">
                        Editar
                    </button>



                        <button
                            type="submit"
                            form="delete-book-form"
                            class="btn btn-neutral"
                            onclick="return confirm('Tem a certeza que quer apagar este livro?')"
                        >
                            Apagar
                        </button>


                </div>
            </div>
        </form>



        <form
            id="delete-book-form"
            method="POST"
            action="/livros/{{ $livro->id }}"
        >
            @csrf
            @method('DELETE')
        </form>

</x-layouts.layout>
