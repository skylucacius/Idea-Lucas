
<!DOCTYPE html>
    <html lang="pt"
    x-data="{ theme: localStorage.getItem('theme') || 'light' }"
      :data-theme="theme">
      <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Minha Aplicação</title>
          @vite(['resources/css/app.css', 'resources/js/app.js'])
        </head>
<body class="bg-base-100 text-base-content min-h-screen">

    {{-- Botão / Toggle para alterar o tema --}}
    <div class="p-4 flex justify-end">
        <button
        @click="theme = (theme === 'light' ? 'dark' : 'light'); localStorage.setItem('theme', theme)"
            class="btn btn-outline">
            <span x-text="theme === 'light' ? '🌙 Modo Escuro' : '☀️ Modo Claro'"></span>
        </button>
    </div>

    <main class="container mx-auto p-6">
        {{ $slot }}
    </main>

</body>
</html>
