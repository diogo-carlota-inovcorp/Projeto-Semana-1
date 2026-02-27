<x-layouts.layout>
    <form method="POST"
          action="{{ route('admin.adicionar_editora.store') }}"
          enctype="multipart/form-data">
        @csrf

        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4 mx-auto">
            <legend class="fieldset-legend">Adicionar editora</legend>

            <label class="label" for="nome">Nome</label>
            <input type="text" name="nome" class="input" placeholder="Nome do autor" required />
            <x-forms.error name="nome" />

            <label class="label" for="logo">Logo</label>
            <input type="file" name="logo" class="file-input file-input-bordered" accept="image/*" />
            <x-forms.error name="logo" />

            <button class="btn btn-neutral mt-4 w-full">Adicionar Editora</button>
        </fieldset>
    </form>
</x-layouts.layout>

