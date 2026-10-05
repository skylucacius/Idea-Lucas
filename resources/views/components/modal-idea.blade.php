@props(['name' => 'open-modal', 'title' => 'Criar Nova Ideia'])

<div
    x-data="{ open: false }"
    @keydown.escape.window="open = false"
    x-on:{{ $name }}.window="open = true"
>
    <!-- Overlay do Fundo (Backdrop) -->
    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-1000"
        x-transition:enter-start="opacity-0 backdrop-blur-none"
        x-transition:enter-end="opacity-100 backdrop-blur-md"
        x-transition:leave="transition ease-in duration-1000"
        x-transition:leave-start="opacity-100 backdrop-blur-md"
        x-transition:leave-end="opacity-0 backdrop-blur-none"
        @click="open = false"
        class="fixed inset-0 z-50 bg-black/60 backdrop-blur-md flex items-center justify-center p-4"
    >
        <!-- Card do Modal -->
        <div
            @click.stop
            x-show="open"
            x-transition:enter="transition ease-out duration-1000"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-1000"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative w-full max-w-lg bg-[#18181b] border border-zinc-800/80 rounded-xl p-6 shadow-2xl text-zinc-300"
        >
            <!-- Cabeçalho -->
            <div class="flex items-center justify-between pb-3 mb-4 border-b border-zinc-800/80">
                <h3 class="text-base font-semibold text-zinc-100">
                    {{ $title }}
                </h3>

                <button
                    type="button"
                    @click="open = false"
                    class="text-zinc-400 hover:text-white p-1 rounded-lg hover:bg-zinc-800/60 transition-colors"
                    aria-label="Fechar"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Formulário inserido via slot -->
            {{ $slot }}

        </div>
    </div>
</div>
