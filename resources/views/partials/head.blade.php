<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

<title>
    {{ filled($title ?? null) ? $title.' - '.config('app.name', ' App') : config('app.name', 'Meu App') }}
</title>
{{-- <title>Minha Aplicação</title> --}}

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

@fonts
@vite(['resources/css/app.css', 'resources/js/app.js'])
{{-- @fluxAppearance --}}

<!-- Script Inline para evitar Flash (FOUC) ao carregar a página -->
<script>
    // const savedTheme = localStorage.getItem('theme') || 'dark';
    // document.documentElement.setAttribute('data-theme', savedTheme);
    // localStorage.setItem('theme', 'dark'); // ou o tema padrão desejado



    // if (savedTheme === 'dark') {
    //     // document.documentElement.classList.add('dark');
    //     localStorage.setItem('theme', 'dark'); // ou o tema padrão desejado
    // } else {
    //     // document.documentElement.classList.remove('dark');
    //     localStorage.setItem('theme', 'dark'); // ou o tema padrão desejado
    // }

    // // Executa assim que a página carrega
    // document.addEventListener('DOMContentLoaded', () => {
    // // 1. Define o tema no localStorage se ainda não existir
    // if (!localStorage.getItem('theme')) {
    // localStorage.setItem('theme', 'dark'); // ou o tema padrão desejado
    // }

    // 2. Aplica o tema salvo no HTML/DOM
    //   const currentTheme = localStorage.getItem('theme');
    //   document.documentElement.setAttribute('data-theme', currentTheme);
    // });
</script>
@vite(['resources/css/app.css', 'resources/js/app.js'])


