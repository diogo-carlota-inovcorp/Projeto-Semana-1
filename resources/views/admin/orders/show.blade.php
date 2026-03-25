<x-layouts.layout title="Detalhe da Encomenda">

    <div class="max-w-5xl mx-auto py-10 px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Encomenda #{{ $order->id ?? '' }}</h1>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline">Voltar</a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="card bg-base-200 shadow">
                    <div class="card-body">
                        <h2 class="card-title">Livros</h2>

                        @foreach($order->items ?? [] as $item)
                            <div class="flex justify-between border-b border-base-300 py-3">
                                <div>
                                    <div class="font-semibold">{{ $item->livro->nome ?? 'Livro' }}</div>
                                    <div class="text-sm text-base-content/70">Qtd: {{ $item->quantity }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="card bg-base-200 shadow">
                    <div class="card-body">
                        <h2 class="card-title">Informação</h2>
                        <p><strong>Cliente:</strong> {{ $order->user->name ?? '—' }}</p>
                        <p><strong>Email:</strong> {{ $order->user->email ?? '—' }}</p>
                        <p><strong>Morada:</strong> {{ $order->morada ?? '—' }}</p>
                        <p><strong>Estado:</strong> {{ $order->estado ?? '—' }}</p>
                        <p><strong>Total:</strong> {{ number_format($order->total ?? 0, 2, ',', '.') }} €</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layouts.layout>
