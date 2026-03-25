<x-layouts.layout title="Gestão de Encomendas">
    <div class="container mx-auto py-8 px-4">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Gestão de Encomendas</h1>

        </div>

        <div class="overflow-x-auto bg-base-200 rounded-xl shadow">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Utilizador</th>
                        <th>Total</th>
                        <th>Data</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>
                                {{ $order->user->name ?? $order->user->nome ?? 'N/A' }}
                                <br>
                                <small class="text-gray-500">{{ $order->user->email ?? '' }}</small>
                            </td>

                            <td>{{ number_format($order->total, 2, ',', '.') }} €</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.orders.show', $order) }}"
                                       class="btn btn-sm btn-info">
                                        Detalhes
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8">
                                <div class="alert alert-info">
                                    Não existem encomendas registadas.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>



    </div>
</x-layouts.layout>
