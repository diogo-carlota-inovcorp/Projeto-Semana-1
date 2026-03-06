<x-layouts.layout title="Admin - Utilizadores">

    <div class="p-6 space-y-6">

        <h1 class="text-3xl font-bold">Gestão de Utilizadores</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        {{-- Search --}}
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-2">
            <input
                type="text"
                name="q"
                value="{{ $q }}"
                placeholder="Pesquisar por nome ou email..."
                class="input input-bordered w-full max-w-md"
            />
            <button class="btn btn-primary" type="submit">Pesquisar</button>
            @if($q)
                <a class="btn btn-ghost" href="{{ route('admin.users.index') }}">Limpar</a>
            @endif
        </form>

        {{-- Users table --}}
        <div class="overflow-x-auto bg-base-200 rounded-lg">
            <table class="table">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th class="text-right">Ações</th>
                </tr>
                </thead>

                <tbody>
                @forelse($users as $user)
                    <tr>
                        <td class="font-semibold">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge badge-success">Admin</span>
                            @else
                                <span class="badge badge-ghost">Cidadão</span>
                            @endif
                        </td>

                        <td class="text-right">
                            <div class="flex justify-end items-center gap-2">

                                <a href="{{ route('admin.users.requisicoes', $user) }}"
                                   class="btn btn-sm btn-info">
                                    Ver Requisições
                                </a>

                                @if($user->role === 'admin')
                                    <form method="POST"
                                          action="{{ route('admin.users.demote', $user->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm btn-warning"
                                                onclick="return confirm('Remover Admin de {{ $user->name }}?')">
                                            Tornar Cidadão
                                        </button>
                                    </form>
                                @else
                                    <form method="POST"
                                          action="{{ route('admin.users.promote', $user->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm btn-success"
                                                onclick="return confirm('Promover {{ $user->name }} a Admin?')">
                                            Tornar Admin
                                        </button>
                                    </form>
                                @endif

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Nenhum utilizador encontrado.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $users->links() }}

    </div>

</x-layouts.layout>
