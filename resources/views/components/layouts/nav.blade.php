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

            </ul>
        </div>
        <a class="btn btn-ghost text-xl " href="/livros/index" >Home</a>
    </div>
    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal px-1 font-bold text-md">
            <li><a href="{{ route('livros.livro') }}">Livros</a></li>
            <li><a href="{{ route('livros.editora') }}">Editoras</a></li>
            <li><a href="{{ route('livros.autor') }}">Autores</a></li>
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

        @endauth
    </div>
</div>

