<!DOCTYPE html>
<html lang="pt"
      x-data="{ theme: localStorage.getItem('theme') || 'light' }"
      :data-theme="theme"
      :class="{ 'dark': theme === 'dark' }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Aplicação</title>
<!-- Script Inline para evitar Flash (FOUC) ao carregar a página -->
    <script>
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
        if (savedTheme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>



<body class="bg-base-100 text-base-content min-h-screen antialiased flex flex-col">
    Testando
    @include('layouts.app.header')

    {{-- Botão para alterar o tema --}}
    <div class="p-4 flex justify-end">
        <button
            @click="theme = (theme === 'light' ? 'dark' : 'light'); localStorage.setItem('theme', theme)"
            class="btn btn-outline">
            <span x-text="theme === 'light' ? '🌙 Modo Escuro' : '☀️ Modo Claro'"></span>
        </button>
    </div>

    <main class="flex-1 flex flex-col justify-center items-center">
        {{ $slot }}
    </main>

</body>
</html>
