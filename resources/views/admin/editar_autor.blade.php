<x-layouts.layout title="Editar Autor">

    <div class="max-w-2xl mx-auto">
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h1 class="card-title text-2xl mb-4">Editar Autor</h1>

                <form method="POST" action="{{ route('livros.update_autor', $autor->id) }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="label">
                            <span class="label-text">Nome</span>
                        </label>
                        <input
                            type="text"
                            name="nome"
                            value="{{ old('nome', $autor->nome) }}"
                            class="input input-bordered w-full"
                            required
                        />
                        @error('nome')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="label">
                            <span class="label-text">Foto</span>
                        </label>
                        <input
                            type="file"
                            name="foto"
                            class="file-input file-input-bordered w-full"
                        />
                        @error('foto')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('livros.autor') }}" class="btn btn-outline">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-layouts.layout>
