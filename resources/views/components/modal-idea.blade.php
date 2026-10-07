@props(['name' => 'open-modal', 'title' => 'Criar Nova Ideia'])

<div
    x-data="{ open: false }"
    @keydown.escape.window="open = false"
    x-on:{{ $name }}.window="open = true"
>
    <!-- Overlay de Fundo (Fixo cobrindo toda a tela) -->
    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
        @click="open = false"
    >
        <!-- Card do Modal -->
        <div
            @click.stop
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative w-full max-w-lg max-h-[85vh] flex flex-col bg-[#18181b] border border-zinc-800/80 rounded-xl p-6 shadow-2xl text-zinc-300 overflow-hidden"
        >
            <!-- Cabeçalho (Fixo no topo do card) -->
            <div class="flex items-center justify-between pb-3 mb-4 border-b border-zinc-800/80 shrink-0">
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

            <!-- Conteúdo Rolável (Slot onde entra o formulário) -->
            <div class="overflow-y-auto pl-3 pr-3 flex-1">
                {{ $slot }}
            </div>

        </div>
    </div>
</div>