<x-layouts.layout>


    <div class="max-w-md mx-auto mt-10 p-6 bg-base-200 rounded-box">
        <h1 class="text-xl font-bold mb-2">Verificar email</h1>
        <p class="mb-4">Enviámos um link de verificação para o teu email. Clica no link para ativar a conta.</p>

        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success mb-4">
                Link reenviado com sucesso.
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button class="btn btn-primary w-full">Reenviar email</button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button class="btn btn-error btn-outline w-full">Sair</button>
        </form>
    </div>


</x-layouts.layout>
