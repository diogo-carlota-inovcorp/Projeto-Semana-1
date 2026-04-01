<div class="navbar bg-base-200">
    <div class="navbar-start">
        <div class="dropdown">
            <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /> </svg>
            </div>
            <ul
                tabindex="-1"
                class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                <li><a href="{{ route('livros.livro') }}">Livros</a></li>
                <li><a href="{{ route('livros.editora') }}">Editoras</a></li>
                <li><a href="{{ route('livros.autor') }}">Autores</a></li>
                @auth
                    <li><a href="{{ route('requisicoes.index') }}">Requisições</a></li>
                @endauth

            </ul>
        </div>
        <a class="btn btn-ghost text-xl " href="/livros/index" >Home</a>

    </div>
    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal px-1 font-bold text-md">
            <li><a href="{{ route('livros.livro') }}">Livros</a></li>
            <li><a href="{{ route('livros.editora') }}">Editoras</a></li>
            <li><a href="{{ route('livros.autor') }}">Autores</a></li>

            @can('ViewAdicionar')
                <li><a href="{{ route('google-books.index') }}">Buscar Livros</a></li>
            @endcan
            @auth

                <li><a href="{{ route('requisicoes.index') }}">Requisições</a></li>
            @endauth
        </ul>
    </div>
    <div class="navbar-end space-x-2">
        @guest
            <a class="btn btn-soft btn-warning" href="/register">Register</a>
            <a class="btn btn-soft btn-accent" href="/login" >Login</a>
        @endguest


        @auth

                @can('ViewAdicionar')
                    <a class="btn btn-soft" href="/admin/admin">Admin</a>

                @endcan


            <form method="POST" action="/logout">
                @csrf
                @method('DELETE')
                <button class="btn btn-error">Log Out</button>
            </form>
                    <a href="{{ route('cart.index') }}" class="relative btn btn-ghost">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 6h13M7 13L5.4 5M10 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"/>
                        </svg>


                        @if(count(session('cart', [])) > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">
            {{ count(session('cart', [])) }}
        </span>
                        @endif

                    </a>

        @endauth
    </div>
</div>

