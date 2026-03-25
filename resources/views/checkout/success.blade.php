<x-layouts.layout title="Pagamento Concluído">

    <div class="max-w-3xl mx-auto py-16 px-4">
        <div class="card bg-base-200 shadow-xl">
            <div class="card-body text-center">
                <h1 class="text-3xl font-bold text-success">Pagamento concluído com sucesso</h1>
                <p class="mt-4 text-base-content/80">
                    A sua encomenda foi registada e paga com sucesso.
                </p>

                <div class="mt-6">
                    <a href="{{ route('orders.index') }}" class="btn btn-primary">Ver encomendas</a>
                    <a href="{{ route('livros.livro') }}" class="btn btn-outline">Voltar aos livros</a>
                </div>
            </div>
        </div>
    </div>

</x-layouts.layout>
