@props([
    'links' => [],
    'action' => 'view'
])

@php
    // Normaliza para array nativo
    $linksArray = is_object($links) && method_exists($links, 'toArray') 
        ? $links->toArray() 
        : (array) $links;

    // Se estiver em modo de edição/criação e estiver vazio, inicia com 1 campo em branco
    if ($action !== 'view' && empty($linksArray)) {
        $linksArray = [''];
    }
@endphp

<div 
    x-data="{ 
        links: {{ json_encode(array_values($linksArray)) }},
        addLink() {
            this.links.push('');
        },
        removeLink(index) {
            this.links.splice(index, 1);
            if (this.links.length === 0 && '{{ $action }}' !== 'view') {
                this.links.push('');
            }
        }
    }" 
    class="space-y-3 pt-4"
>
    <h2 class="
    {{-- text-xl font-semibold text-zinc-900 dark:text-white --}}
    block text-sm font-medium text-zinc-300 mb-1.5
    ">
        Links
    </h2>

    {{-- MODO 1: Apenas Visualização (View) --}}
    @if($action === 'view')
        <div class="space-y-2">
            <template x-for="(link, index) in links" :key="index">
                <div class="flex items-center justify-between gap-3 w-full">
                    <flux:card class="flex-1 min-w-0 bg-zinc-900/50 border-zinc-800 hover:border-zinc-700 transition p-4 rounded-xl">
                        <a :href="link" target="_blank" class="flex items-center gap-2 text-emerald-500 hover:underline break-all">
                            <flux:icon icon="arrow-top-right-on-square" class="size-4 shrink-0" />
                            <span x-text="link"></span>
                        </a>
                    </flux:card>
                </div>
            </template>

            <template x-if="links.length === 0">
                <p class="text-sm text-zinc-500 italic">Nenhum link cadastrado.</p>
            </template>
        </div>

    {{-- MODO 2: Edição ou Criação (Formulário Dinâmico) --}}
    @else
        <div class="space-y-2.5">
            <template x-for="(link, index) in links" :key="index">
                <div class="flex items-center gap-2 w-full">
                    <!-- Input de Link -->
                    <div class="relative flex-1">
                        <input
                            type="url"
                            name="links[]"
                            x-model="links[index]"
                            placeholder="https://exemplo.com"
                            class="w-full bg-[#121215] border border-zinc-800 rounded-lg px-3.5 py-2.5 text-sm text-zinc-100 placeholder-zinc-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition"
                        />
                    </div>

                    <!-- Botão de Remover -->
                    <flux:button 
                        type="button"
                        @click="removeLink(index)"
                        variant="ghost" 
                        icon="trash" 
                        square 
                        aria-label="Deletar link" 
                        class="text-red-500 hover:text-red-400 hover:bg-red-500/10 hover:border hover:border-red-500/30 hover:scale-110 active:scale-95 transition-all duration-200 shadow-sm hover:shadow-red-500/20 shrink-0"
                    />
                </div>
            </template>
        </div>

        <!-- Botão de Adicionar Novo Link (+) -->
        <button
            type="button"
            @click="addLink()"
            class="inline-flex items-center gap-2 text-xs font-medium text-emerald-500 hover:text-emerald-400 hover:underline pt-1 transition-colors"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Adicionar outro link</span>
        </button>

        @error('links')
            <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span>
        @enderror
    @endif
</div>