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
            <div class="overflow-x-auto bg-base-200 rounded-lg shadow">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th>Livro</th>
                            <th>Data de encomenda</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td class="font-medium">
                                    @foreach($order->items as $item)
                                        {{ $item->livro->nome }} <br>
                                    @endforeach
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($order->requisitado_em)->format('d/m/Y H:i') }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.utilizadores.encomendas', $user->id) }}"
   class="btn btn-sm btn-info">
    Ver Encomendas
</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>

</x-layouts.layout>
