<!-- resources/views/admin/logs/index.blade.php -->
<x-layouts.layout title="Logs do Sistema">

    <div class="container mx-auto py-8 px-4">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Logs do Sistema</h1>
            <form method="GET" class="flex gap-2">

                <select name="modulo" class="select select-bordered">
                    <option value="">Todos os módulos</option>
                    @foreach($modulos as $modulo)
                        <option value="{{ $modulo }}" {{ request('modulo') == $modulo ? 'selected' : '' }}>
                            {{ $modulo }}
                        </option>
                    @endforeach
                </select>
                <input type="date" name="date" value="{{ request('date') }}" class="input input-bordered">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <a href="{{ route('admin.logs.index') }}" class="btn btn-warning">Limpar</a>
            </form>
        </div>

        <div class="overflow-x-auto bg-base-200 rounded-xl shadow">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>Data/Hora</th>
                        <th>Utilizador</th>
                        <th>Módulo</th>
                        <th>ID Objeto</th>
                        <th>Alteração</th>
                        <th>IP</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td>{{ $log->data_hora->format('d/m/Y H:i:s') }}</td>
                            <td>{{ $log->user?->name ?? 'Sistema' }}</td>
                            <td>{{ $log->modulo }}</td>
                            <td>{{ $log->objeto_id ?? '-' }}</td>
                            <td class="max-w-md truncate">{{ $log->alteracao }}</td>
                            <td>{{ $log->ip ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.logs.show', $log) }}" class="btn btn-sm btn-info">Ver</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8">Nenhum log encontrado</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $logs->links() }}
        </div>
    </div>
</x-layouts.layout>
