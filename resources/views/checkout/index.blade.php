<x-layouts.layout title="Checkout">

    <div class="max-w-6xl mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold mb-6">Checkout</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2">
                <div class="card bg-base-200 shadow">
                    <div class="card-body">
                        <h2 class="card-title mb-4">Morada de Entrega</h2>

                        <form method="POST" action="{{ route('checkout.address') }}">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input type="text" name="nome" placeholder="Nome completo" class="input input-bordered w-full">
                                <input type="text" name="telefone" placeholder="Telefone" class="input input-bordered w-full">
                            </div>

                            <div class="mt-4">
                                <input type="text" name="morada" placeholder="Morada" class="input input-bordered w-full">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                <input type="text" name="codigo_postal" placeholder="Código Postal" class="input input-bordered w-full">
                                <input type="text" name="cidade" placeholder="Cidade" class="input input-bordered w-full">
                                <input type="text" name="pais" placeholder="País" class="input input-bordered w-full" value="Portugal">
                            </div>

                            <div class="mt-6">
                                <button type="submit" class="btn btn-primary">
                                    Guardar morada
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="card bg-base-200 shadow">
                    <div class="card-body">
                        <h2 class="card-title">Resumo da Encomenda</h2>

                        @foreach($cartItems ?? [] as $item)
                            <div class="flex justify-between text-sm border-b border-base-300 py-2">
                                <span>{{ $item['nome'] }} x{{ $item['quantidade'] }}</span>
                                <span>{{ number_format($item['subtotal'], 2, ',', '.') }} €</span>
                            </div>
                        @endforeach

                        <div class="flex justify-between font-bold text-lg mt-4">
                            <span>Total</span>
                            <span>{{ number_format($total ?? 0, 2, ',', '.') }} €</span>
                        </div>

                        <div class="card-actions justify-end mt-6">
                            <form method="POST" action="{{ route('checkout.stripe') }}">
                                @csrf
                                <button class="btn btn-success w-full">
                                    Pagar com Stripe
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-layouts.layout>
