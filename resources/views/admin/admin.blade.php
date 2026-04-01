<x-layouts.layout title="ideas">
    <div class="text-center">
        <h3 class="text-4xl md:text-5xl font-bold mb-2">
            Bem vindo à aba privada de bibliotecários
        </h3>
        <p class="text-lg md:text-xl text-base-content/80">
            Escolha qual das seguintes áreas quer atualizar
        </p>
    </div>


    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-100 place-items-center py-20 items-stretch">
        <div class="card w-96 bg-base-200 shadow-sm">
            <figure class="h-52 w-full overflow-hidden">

      <img src="/images/livros_aba.jpg" alt="Books" />

  </figure>
  <div class="card-body">

                <div class="flex justify-between">
                    <h2 class="text-3xl font-bold">Adicionar Livros</h2>
                </div>
                <p class="text-lg">Possibilidades:</p>

                <ul class="mt-6 flex flex-col gap-2 text-xs">
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-lg">Adicionar Livro</span>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-lg">Adicionar Editora</span>
                    </li>
                     <li>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-lg">Adicionar Autor</span>
                    </li>
                </ul>

                <div class="mt-6">
                    <a class="btn btn-primary btn-block" href="/admin/admin_adicionar">Consultar</a>
                </div>
            </div></div>

            <div class="card w-96 bg-base-200 shadow-sm">
                <figure class="h-52 w-full overflow-hidden">
  <img src="/images/admins.webp" alt="admins" />
  </figure>
        <div class="card-body flex flex-col justify-between">

        <div>
            <div class="flex justify-between">
                <h2 class="text-3xl font-bold">Consulta Admin</h2>
            </div>

            <p class="text-lg">Possibilidades:</p>

            <ul class="mt-6 flex flex-col gap-2 text-xs">
                <li>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-lg">Ver Reviews</span>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-lg">Ver Utilizadores</span>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-lg">Ver Encomendas</span>
                    </li>
            </ul>
        </div>

        <div class="mt-6">
            <a class="btn btn-primary btn-block" href="{{ route('admin.users.index') }}">
                Consultar
            </a>
        </div>

     </div>
    </div>



        <div class="card w-96 bg-base-200 shadow-sm">
            <figure class="h-52 w-full overflow-hidden">
   <img src="/images/logs.webp" alt="Logs" />
  </figure><div class="card-body">
                <div class="flex justify-between">
                    <h2 class="text-3xl font-bold">Observar Logs</h2>
                </div>

                <p class="text-lg">Possibilidades:</p>


                <ul class="mt-6 flex flex-col gap-2 text-xs">
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-lg">Ver o nome do utilizador</span>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-lg">Ver Data da interação</span>
                    </li>
                     <li>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 me-2 inline-block text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-lg">Ver detalhes do Log</span>
                    </li>

                </ul>
                <div class="mt-6">
                    <a class="btn btn-primary btn-block" href="{{ route('admin.logs.index') }}">Consultar</a>
                </div>
            </div></div>
    </div>
</x-layouts.layout>
