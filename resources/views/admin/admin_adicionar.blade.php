<x-layouts.layout title="ideas">
    <div class="text-center">
        <h3 class="text-4xl md:text-5xl font-bold mb-2">
            Bem vindo à aba privada de bibliotecários
        </h3>
        <p class="text-lg md:text-xl text-base-content/80">
            Escolha qual das seguintes áreas quer atualizar
        </p>
    </div>


    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-100 place-items-center py-30 items-stretch">
        <div class="card w-96 bg-base-200 shadow-sm"><div class="card-body">

                <div class="flex justify-between">
                    <h2 class="text-3xl font-bold">Adicionar Editora</h2>
                </div>
                <p class="text-lg">Informações necessárias:</p>

                <ul class="mt-6 flex flex-col gap-2 text-xs">
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-lg">Nome da empresa editora</span>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-lg">Imagem Logo da empresa</span>
                    </li>
                </ul>

                <div class="mt-4 mb-4 h-28 rounded-xl bg-base-200/10 border border-base-content/10 p-4">
                    <div class="flex gap-2 items-center">
                        <div class="h-14 w-12 rounded-lg bg-base-300/20 border border-base-content/10 flex items-center justify-center text-xs text-base-content/50">
                            IMG
                        </div>
                        <div class="flex-1 space-y-2">
                            <div class="h-3 w-3/4 rounded bg-base-content/10"></div>
                            <div class="h-3 w-2/3 rounded bg-base-content/10"></div>
                            <div class="h-3 w-1/2 rounded bg-base-content/10"></div>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <a class="btn btn-primary btn-block" href="/admin/adicionar_editora">Adicionar</a>
                </div>
            </div></div>
        <div class="card w-96 bg-base-200 shadow-sm"><div class="card-body">
                <div class="flex justify-between">
                    <h2 class="text-3xl font-bold">Adicionar Livro</h2>
                </div>

                <p class="text-lg">Informações necessárias:</p>

                <ul class="mt-6 flex flex-col gap-2 text-xs">
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-lg">Título</span>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-lg">ISBN</span>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-lg">Editora</span>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-lg">Autor</span>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-lg">Bibliografia</span>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-lg">Preço</span>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-lg">Capa do livro</span>
                    </li>

                </ul>
                <div>
                    <a class="btn btn-primary btn-block" href="/admin/adicionar_livro" >Adicionar</a>
                </div>
            </div>
        </div>

        <div class="card w-96 bg-base-200 shadow-sm"><div class="card-body">
                <div class="flex justify-between">
                    <h2 class="text-3xl font-bold">Adicionar Autor</h2>
                </div>

                <p class="text-lg">Informações necessárias:</p>


                <ul class="mt-6 flex flex-col gap-2 text-xs">
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-lg">Nome do Autor</span>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-lg">Foto do Autor</span>
                    </li>

                </ul>

                <div class="mt-4 mb-4 h-28 rounded-xl bg-base-200/10 border border-base-content/10 p-4">
                    <div class="flex gap-2 items-center">
                        <div class="h-14 w-12 rounded-lg bg-base-300/20 border border-base-content/10 flex items-center justify-center text-xs text-base-content/50">
                            IMG
                        </div>
                        <div class="flex-1 space-y-2">
                            <div class="h-3 w-3/4 rounded bg-base-content/10"></div>
                            <div class="h-3 w-2/3 rounded bg-base-content/10"></div>
                            <div class="h-3 w-1/2 rounded bg-base-content/10"></div>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <a class="btn btn-primary btn-block" href="/admin/adicionar_autor" >Adicionar</a>
                </div>
            </div></div>
    </div>
</x-layouts.layout>
