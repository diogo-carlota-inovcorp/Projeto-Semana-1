<x-layouts.layout title="Encomendas de {{ $user->name ?? $user->nome ?? 'Utilizador' }}">

    <div class="container mx-auto py-8">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">
                Encomendas de {{ $user->name ?? $user->nome }}
            </h1>
        </div>

        @if($orders->isEmpty())
            <div class="alert alert-info shadow-lg">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current flex-shrink-0 w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Este utilizador ainda não tem encomendas.</span>
                </div>
            </div>
        @else
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-base-200 rounded-lg shadow overflow-hidden">
                        <div class="bg-base-300 px-4 py-2 flex justify-between items-center">
                            <div>
                                <span class="font-bold">Encomenda #{{ $order->id }}</span>
                                <span class="text-sm ml-4">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div>
                                <span class="font-bold">Total: {{ number_format($order->total, 2, ',', '.') }} €</span>
                                <span class="badge ml-2 {{ $order->estado === 'paga' ? 'badge-success' : 'badge-warning' }}">
                                    {{ ucfirst($order->estado) }}
                                </span>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="table w-full">
                                <thead>
                                    <tr>
                                        <th>Livro</th>
                                        <th>Quantidade</th>
                                        <th>Preço Unitário</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td>{{ $item->livro->nome ?? $item->livro->titulo ?? 'Livro não encontrado' }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>€{{ number_format($item->preco_unitario, 2, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>

</x-layouts.layout>
