<x-layouts.layout>

    <h1 class="text-2xl font-bold mb-6">As Minhas Requisições</h1>

    @foreach($requisicoes as $req)
        <div class="card mb-4 p-4 bg-base-200">
            <h2 class="text-lg font-semibold">{{ $req->livro->nome }}</h2>
            <p>Data requisição: {{ $req->requisitado_em }}</p>
            <p>Entrega prevista: {{ $req->fim_previsto }}</p>
            <p>Status: {{ $req->status }}</p>

            <div class="mt-4 flex gap-2">
                @if(in_array($req->status, ['pendente', 'ativa']))
                    <form method="POST" action="{{ route('requisicoes.pedirDevolucao', ['requisicao' => $req->id]) }}">
                        @csrf
                        @method('PATCH')

                        <button class="btn btn-success"
                                onclick="return confirm('Enviar pedido de devolução?');">
                            Pedir Devolução
                        </button>
                    </form>
                @endif

                @if($req->status === 'por_confirmar')
                    <span class="badge badge-warning">A aguardar confirmação do admin</span>
                @endif

                @if($req->status === 'entregue' && ! $req->review)
                    <button
                        type="button"
                        class="btn btn-primary"
                        onclick="document.getElementById('review-modal-{{ $req->id }}').showModal()"
                    >
                        Fazer review
                    </button>
                @endif
            </div>
        </div>

        @if($req->status === 'entregue' && ! $req->review)
            <dialog id="review-modal-{{ $req->id }}" class="modal">
                <div class="modal-box max-w-2xl">
                    <h3 class="font-bold text-lg mb-4">Faz a tua review</h3>

                    <form method="POST" action="{{ route('reviews.store', ['requisicao' => $req->id]) }}">
                        @csrf

                        <div class="mb-4">
                            <label class="label">
                                <span class="label-text">Classificação</span>
                            </label>

                            <div class="rating rating-lg">
                                <input type="radio" name="rating" value="1" class="mask mask-star-2 bg-warning" />
                                <input type="radio" name="rating" value="2" class="mask mask-star-2 bg-warning" />
                                <input type="radio" name="rating" value="3" class="mask mask-star-2 bg-warning" />
                                <input type="radio" name="rating" value="4" class="mask mask-star-2 bg-warning" />
                                <input type="radio" name="rating" value="5" class="mask mask-star-2 bg-warning" />
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="label">
                                <span class="label-text">Comentário</span>
                            </label>

                            <textarea
                                name="comentario"
                                rows="5"
                                class="textarea textarea-bordered w-full"
                                placeholder="Escreve a tua opinião sobre o livro..."
                            ></textarea>
                        </div>

                        <div class="modal-action">
                            <button type="submit" class="btn btn-primary">Submeter review</button>
                            <button type="button" class="btn" onclick="document.getElementById('review-modal-{{ $req->id }}').close()">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </dialog>
        @endif
    @endforeach

</x-layouts.layout>
