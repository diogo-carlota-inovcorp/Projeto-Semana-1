<x-layouts.layout title="Detalhes do Log">

    <div class="container mx-auto py-8 px-4">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Detalhes do Log</h1>
            <a href="{{ route('admin.logs.index') }}" class="btn btn-ghost btn-sm">
                ← Voltar para Logs
            </a>
        </div>

        <div class="bg-base-200 rounded-lg shadow p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-xl font-bold mb-4">Informações</h2>
                    <div class="space-y-3">
                        <p><strong>ID:</strong> {{ $log->id }}</p>
                        <p><strong>Data/Hora:</strong> {{ $log->data_hora->format('d/m/Y H:i:s') }}</p>
                        <p><strong>Utilizador:</strong> {{ $log->user?->name ?? $log->user?->nome ?? 'Sistema' }}</p>
                        <p><strong>Módulo:</strong> {{ $log->modulo }}</p>
                        <p><strong>ID do Objeto:</strong> {{ $log->objeto_id ?? 'N/A' }}</p>
                        <p><strong>IP:</strong> {{ $log->ip ?? 'N/A' }}</p>
                        <p><strong>Browser:</strong> {{ $log->browser ?? 'N/A' }}</p>
                    </div>
                </div>
                <div>
                    <h2 class="text-xl font-bold mb-4">Alteração</h2>
                    <div class="bg-base-100 p-4 rounded-lg overflow-x-auto">
                        <pre class="whitespace-pre-wrap text-sm">{{ $log->alteracao }}</pre>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-base-300">
                <form action="{{ route('admin.logs.destroy', $log) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error btn-sm" onclick="return confirm('Tem certeza que deseja remover este log?')">
                        Remover Log
                    </button>
                </form>
            </div>
        </div>

    </div>

</x-layouts.layout>
