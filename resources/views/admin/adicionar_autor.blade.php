<x-layouts.layout>
    <form method="POST"
          action="{{ route('admin.adicionar_autor.store') }}"
          enctype="multipart/form-data">
        @csrf

        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4 mx-auto">
            <legend class="fieldset-legend">Adicionar Autor</legend>

            <label class="label" for="nome">Nome</label>
            <input type="text" name="nome" class="input" placeholder="Nome do autor" required />
            <x-forms.error name="nome" />

            <label class="label" for="foto">Foto</label>
            <input type="file" name="foto" class="file-input file-input-bordered" accept="image/*" />
            <x-forms.error name="foto" />

            <button class="btn btn-neutral mt-4 w-full">Adicionar Autor</button>
        </fieldset>
    </form>
</x-layouts.layout>
