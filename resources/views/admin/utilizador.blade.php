<x-layouts.layout title="ideas">
    <div class="text-center">
        <h3 class="text-4xl md:text-5xl font-bold mb-2">
            Bem vindo à aba privada de Utilizadores
        </h3>
        <p class="text-lg md:text-xl text-base-content/80">
            Escolha qual das seguintes áreas quer pesquisar
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-100 place-items-center py-30 items-stretch">
        <div class="card w-96 bg-base-200 shadow-sm">
            <div class="card-body">
                <div class="flex justify-between">
                    <h2 class="text-3xl font-bold">Ver Reviews</h2>
                </div>

                <p class="text-lg">Informações:</p>

                <ul class="mt-6 flex flex-col gap-2 text-xs">
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-lg">Nome do utilizador</span>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-lg">Review entregue</span>
                    </li>
                </ul>

                <div class="mt-6">
                    <a class="btn btn-primary btn-block" href="{{ route('admin.reviews.index') }}">Ver</a>
                </div>
            </div>
        </div>

        <div class="card w-96 bg-base-200 shadow-sm">
            <div class="card-body">
                <div class="flex justify-between">
                    <h2 class="text-3xl font-bold">Ver utilizadores</h2>
                </div>

                <p class="text-lg">Informações:</p>

                <ul class="mt-6 flex flex-col gap-2 text-xs">
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-lg">Nome do utilizador</span>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-lg">Histórico do utilizador</span>
                    </li>
                </ul>

                <div class="mt-6">
                    <a class="btn btn-primary btn-block" href="{{ route('admin.users.gestao') }}">Ver</a>
                </div>
            </div>
        </div>

        <div class="card w-96 bg-base-200 shadow-sm">
            <div class="card-body">
                <div class="flex justify-between">
                    <h2 class="text-3xl font-bold">Ver encomendas</h2>
                </div>

                <p class="text-lg">Informações:</p>

                <ul class="mt-6 flex flex-col gap-2 text-xs">
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-lg">Nome do utilizador</span>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-lg">Encomenda entregue</span>
                    </li>
                </ul>

                   <div class="mt-6">
                        <a class="btn btn-primary btn-block" href="{{ route('admin.orders.index') }}">Ver</a>
                    </div>
            </div>
        </div>
        
    </div>
</x-layouts.layout>
