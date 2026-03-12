<x-layouts.layout title="Editar Editora">

    <div class="max-w-2xl mx-auto">
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h1 class="card-title text-2xl mb-4">Editar Editora</h1>

                <form method="POST" action="{{ route('livros.update_editora', $editora->id) }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="label">
                            <span class="label-text">Nome</span>
                        </label>
                        <input
                            type="text"
                            name="nome"
                            value="{{ old('nome', $editora->nome) }}"
                            class="input input-bordered w-full"
                            required
                        />
                        @error('nome')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="label">
                            <span class="label-text">Logo</span>
                        </label>
                        <input
                            type="file"
                            name="logo"
                            class="file-input file-input-bordered w-full"
                        />
                        @error('logo')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('livros.editora') }}" class="btn btn-outline">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-layouts.layout>
