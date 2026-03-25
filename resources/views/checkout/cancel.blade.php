<x-layouts.layout title="Pagamento Cancelado">

    <div class="max-w-3xl mx-auto py-16 px-4">
        <div class="card bg-base-200 shadow-xl">
            <div class="card-body text-center">
                <h1 class="text-3xl font-bold text-warning">Pagamento não concluído</h1>
                <p class="mt-4 text-base-content/80">
                    O pagamento foi cancelado ou ficou pendente.
                </p>

                <div class="mt-6">
                    <a href="{{ route('checkout.index') }}" class="btn btn-primary">Tentar novamente</a>
                    <a href="{{ route('cart.index') }}" class="btn btn-outline">Voltar ao carrinho</a>
                </div>
            </div>
        </div>
    </div>

</x-layouts.layout>
