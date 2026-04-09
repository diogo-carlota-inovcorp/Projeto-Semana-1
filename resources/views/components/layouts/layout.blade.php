@props([
       'title' => 'placeholder'

])


    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> {{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="text-secondary-content">
<x-layouts.nav>

</x-layouts.nav>

<div class="fixed top-20 left-4 flex flex-col items-center gap-2 z-50">

@auth
    @php $user = auth()->user(); @endphp

    <a href="/perfil" class="relative">
        <div class="relative inline-block">
            <img
                src="{{ $user->foto_perfil
                    ? asset('storage/' . $user->foto_perfil)
                    : asset('images/autor-default.jpg') }}"
                alt="Profile"
                class="w-12 h-12 rounded-full object-cover border-2 border-primary"
            >
        </div>
    </a>
@endauth

</div>
<main class="max-w-3xl mx-auto mt-6 ">

    @if (session('success'))
        <div id="flash-success" class="alert alert-success mb-4">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(() => {
                const el = document.getElementById('flash-success');
                if (el) {
                    el.classList.add('opacity-0');
                    setTimeout(() => el.remove(), 300);
                }
            }, 2000);
        </script>
    @endif



    {{ $slot }}
</main>



</body>
</html>


