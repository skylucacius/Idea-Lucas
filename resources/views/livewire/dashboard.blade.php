<?php

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use function Livewire\Volt\{computed};

// Busca TODAS as ideias do usuário uma única vez
$ideas = computed(function () {
    /** @var User|null $user */
    $user = Auth::user();
    return $user ? $user->ideas()->latest()->get() : collect();
});

?>

<div 
    x-data="{ 
        selectedStatus: 'All',
        // Função auxiliar para verificar se a ideia deve ser exibida
        isVisible(status) {
            return this.selectedStatus === 'All' || this.selectedStatus === status;
        },
        // Quantidade total de ideias visíveis no momento
        get totalVisible() {
            if (this.selectedStatus === 'All') return {{ $this->ideas->count() }};
            
            // Conta os cards que batem com o status atual
            const statusMap = @js($this->ideas->pluck('status.value'));
            return statusMap.filter(s => s === this.selectedStatus).length;
        }
    }"
    @filter-changed.window="selectedStatus = $event.detail.status"
>
    <!-- Cabeçalho da Página -->
    <div class="flex items-center justify-between mb-6 mt-10">
        <div>
            <h1 class="text-xl font-semibold text-white">Ideias</h1>
            <p class="text-sm text-zinc-400">Gerencie e acompanhe as sugestões</p>
        </div>

        <!-- Botão de Criar Ideia -->
        <button
            @click="$dispatch('open-modal')"
            class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white font-medium text-sm rounded-lg shadow-lg shadow-emerald-900/20"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Nova Ideia</span>
        </button>
    </div>

    <x-modal-idea>
        <x-save-idea-form />
    </x-modal-idea>
        
    @if ($this->ideas->isNotEmpty())
        <!-- Filtro -->
        <x-ideas-filter 
            :selectedStatus="'All'" 
            event="filter-changed"
        />
    @endif

    <!-- Exibição das Ideias -->
    <div class="w-full py-6">
        <div class="w-[90vw] max-w-[90vw] mx-auto grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse ($this->ideas as $idea)
                <a 
                    href="{{ route('ideas.show', $idea->id) }}" 
                    class="block no-underline"
                    x-show="isVisible('{{ $idea->status->value }}')"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                >
                    <livewire:idea.card :idea="$idea" :key="$idea->id" />
                </a>
            @empty
                <div class="col-span-2 p-8 text-center border border-dashed border-neutral-800 rounded-xl text-neutral-500">
                    Você ainda não possui nenhuma ideia cadastrada.
                </div>
            @endforelse

            <!-- Mensagem quando o filtro selecionado não retorna resultados -->
            @if ($this->ideas->isNotEmpty())
                <div 
                    x-show="totalVisible === 0" 
                    x-cloak 
                    class="col-span-2 p-8 text-center border border-dashed border-neutral-800 rounded-xl text-neutral-500"
                >
                    Nenhuma ideia encontrada para o status selecionado.
                </div>
            @endif
        </div>
    </div>
</div>