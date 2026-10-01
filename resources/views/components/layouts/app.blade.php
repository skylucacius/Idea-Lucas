<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark"
    {{-- lang="pt" --}}
    x-data="{ theme: localStorage.getItem('theme') || 'light' }"
    :data-theme="theme"
    :class="{ 'dark': theme === 'dark' }"
>
<head> @include('partials.head') </head>

<body class="bg-base-100 text-base-content min-h-screen antialiased flex flex-col">
    <body class="min-h-screen bg-white dark:bg-zinc-800">
    @include('layouts.app.header')
    {{-- @include('layouts.app.sidebar') --}}


    <main class="flex-1 flex flex-col
    {{-- justify-center  --}}
    items-center">
        {{ $slot }}
    </main>

</body>
</html>
