<x-layouts.layout title="As Minhas Encomendas">

    <div class="max-w-6xl mx-auto py-10 px-4">

        @if(isset($userModel))
            <h1 class="text-3xl font-bold mb-2">Encomendas de: {{ $userModel->name }}</h1>
        @else
            <h1 class="text-3xl font-bold mb-6">As Minhas Encomendas</h1>
        @endif

        <div class="space-y-6">
            @forelse($orders ?? [] as $order)
                <div class="bg-base-200 rounded-xl shadow overflow-hidden">
                    <div class="bg-base-300 px-6 py-3 flex justify-between items-center">
                        <div>
                            <span class="font-bold">Encomenda #{{ $order->id }}</span>
                            <span class="text-sm ml-4">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div>
                            <span class="font-bold mr-4">Total: {{ number_format($order->total, 2, ',', '.') }} €</span>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                                    <tr>
                                        <th>Livro</th>
                                        <th>Quantidade</th>
                                    </tr>
                            </thead>
                            <tbody>
                                @forelse($order->items as $item)
                                    <tr>
                                        <td>
                                            @if($item->livro)
                                                {{ $item->livro->nome ?? $item->livro->titulo ?? 'Livro não encontrado' }}
                                            @else
                                                Livro não encontrado
                                            @endif
                                        </td>
                                        <td>{{ $item->quantity }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Sem itens nesta encomenda</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                <div class="alert alert-info">
                    @if(isset($userModel))
                        Este utilizador ainda não tem encomendas.
                    @else
                        Ainda não existem encomendas.
                    @endif
                </div>
            @endforelse
        </div>
    </div>

</x-layouts.layout>
