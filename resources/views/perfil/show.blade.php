<x-layouts.layout>
    <div class="container py-4">
        <h1 class="mb-4">Meu Perfil</h1>

        @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="card p-4" style="max-width: 700px; border-radius: 18px;">
            <form method="POST" action="{{ route('perfil.update') }}" enctype="multipart/form-data">
                @csrf

                <div class="d-flex align-items-center gap-4 mb-4">
                    <img
                        src="{{ $user->foto_perfil ? asset('storage/'.$user->foto_perfil) : asset('images/default-avatar.png') }}"
                        alt="Foto de perfil"
                        style="width:140px; height:140px; border-radius:50%; object-fit:cover; border:3px solid #d1d5db;"
                    >

                    <div>
                        <input
                            type="file"
                            name="foto_perfil"
                            id="foto_perfil"
                            accept="image/*"
                            style="display:none;"
                        >

                        <label for="foto_perfil" class="btn btn-primary">
                            Escolher Nova Foto
                        </label>

                        <button type="submit" class="btn btn-success ms-2">
                            Guardar Alterações
                        </button>

                        @error('foto_perfil')
                        <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Nome</label>
                    <div>{{ $user->name }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <div>{{ $user->email }}</div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.layout>
