<x-layouts.layout title="Sugerir Livro">

    <div class="max-w-xl mx-auto">

        <h1 class="text-2xl font-bold mb-6">
            Sugere um livro
        </h1>

        <form method="POST" action="{{ route('google-books.store') }}" class="space-y-4">

            @csrf

            <div>
                <label>Email</label>
                <input type="email" name="email" class="input input-bordered w-full" required>
            </div>

            <div>
                <label>Nome do livro</label>
                <input type="text" name="book_name" class="input input-bordered w-full" required>
            </div>

            <div>
                <label>Porque gostas deste livro?</label>
                <textarea name="reason" class="textarea textarea-bordered w-full" required></textarea>
            </div>

            <button class="btn btn-primary">
                Enviar pedido
            </button>

        </form>

    </div>

</x-layouts.layout>
