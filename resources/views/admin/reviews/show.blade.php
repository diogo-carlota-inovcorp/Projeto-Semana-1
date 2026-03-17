<x-layouts.layout title="Moderar Review">

    <div class="max-w-3xl mx-auto">
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h1 class="card-title text-2xl mb-4">Moderar Review</h1>

                <div class="space-y-2 mb-6">
                    <p><strong>Livro:</strong> {{ $review->livro->nome }}</p>
                    <p><strong>Cidadão:</strong> {{ $review->user->name }}</p>
                    <p><strong>Email:</strong> {{ $review->user->email }}</p>
                    <p><strong>Classificação:</strong> {{ $review->rating }}/5</p>
                    <p><strong>Comentário:</strong></p>

                    <div class="bg-base-200 p-4 rounded-lg">
                        {{ $review->comentario }}
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.reviews.update', $review) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="label">
                            <span class="label-text">Estado</span>
                        </label>

                        <select name="estado" id="estado" class="select select-bordered w-full">
                            <option value="suspenso" {{ old('estado', $review->estado) === 'suspenso' ? 'selected' : '' }}>Suspenso</option>
                            <option value="ativo" {{ old('estado', $review->estado) === 'ativo' ? 'selected' : '' }}>Ativo</option>
                            <option value="recusado" {{ old('estado', $review->estado) === 'recusado' ? 'selected' : '' }}>Recusado</option>
                        </select>
                    </div>

                    <div id="justificacao-box">
                        <label class="label">
                            <span class="label-text">Justificação</span>
                        </label>

                        <textarea
                            name="justificacao"
                            rows="4"
                            class="textarea textarea-bordered w-full"
                        >{{ old('justificacao', $review->justificacao) }}</textarea>

                        @error('justificacao')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline">Voltar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleJustificacao() {
            const estado = document.getElementById('estado').value;
            const box = document.getElementById('justificacao-box');
            box.style.display = estado === 'recusado' ? 'block' : 'none';
        }

        document.getElementById('estado').addEventListener('change', toggleJustificacao);
        window.addEventListener('load', toggleJustificacao);
    </script>

</x-layouts.layout>
