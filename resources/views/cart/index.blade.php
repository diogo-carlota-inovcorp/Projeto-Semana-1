<x-layouts.layout title="Carrinho">

    <div class="max-w-6xl mx-auto py-10 px-4">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold">Carrinho de Compras</h1>
            <a href="{{ route('livros.livro') }}" class="btn btn-outline">Continuar a comprar</a>
        </div>

        @if($cartItems->isEmpty())
            <div class="alert alert-info">
                O seu carrinho está vazio.
            </div>
        @else
            <div class="overflow-x-auto bg-base-200 rounded-xl shadow">
                <table class="table w-full">
                    <thead>
                    <tr>
                        <th>Livro</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cartItems as $item)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <img src="{{ $item['imagem_capa'] ?: asset('images/capa-default.jpg') }}"
                                         class="w-14 rounded"
                                         alt="{{ $item['nome'] }}">
                                    <div>
                                        <div class="font-semibold">{{ $item['nome'] }}</div>
                                        <div class="text-sm text-base-content/70">{{ $item['autor'] ?? '—' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ number_format($item['preco'], 2, ',', '.') }} €</td>
                            <td>{{ $item['quantidade'] }}</td>
                            <td>{{ number_format($item['subtotal'], 2, ',', '.') }} €</td>
                            <td class="text-right">
                                <form method="POST" action="{{ route('cart.remove', $item['livro_id']) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-error btn-sm">
                                        Remover
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-8 flex justify-end">
                <div class="card bg-base-200 w-full max-w-md shadow">
                    <div class="card-body">
                        <h2 class="card-title">Resumo</h2>
                        <div class="flex justify-between">
                            <span>Total</span>
                            <span class="font-bold">{{ number_format($total, 2, ',', '.') }} €</span>
                        </div>

                        <div class="card-actions justify-end mt-4">
                            <a href="{{ route('checkout.index') }}" class="btn btn-primary">
                                Finalizar Encomenda
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

</x-layouts.layout>
