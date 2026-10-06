<?php

use App\Concerns\WithIdeaFilter;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use function Livewire\Volt\{computed, state, uses};
uses(WithIdeaFilter::class);

$ideas = computed(function () {
    /** @var User|null $user */
    $user = Auth::user();
    $query = $user ? $user->ideas()->latest() : collect();
    // Se um status específico for selecionado (diferente de 'All'), filtra no banco de dados
    if ($this->selectedStatus !== 'All') {
        $query->where('status', $this->selectedStatus);
    }
    return $query->get();
});

state(['show' => false]);

?>

<div>
    <!-- Cabeçalho da Página -->
    <div class="flex items-center justify-between mb-6 mt-10">
        <div>
            <h1 class="text-xl font-semibold text-white">Ideias</h1>
            <p class="text-sm text-zinc-400">Gerencie e acompanhe as sugestões</p>
        </div>

        <!-- Botão de Criar Ideia -->
        <button
        @click="$dispatch('open-modal')"
        class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white font-medium text-sm rounded-lg shadow-lg shadow-emerald-900/20">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        <span>Nova Ideia</span>
    </button>
    </div>
        <x-modal-idea>
            <x-save-idea-form />
        </x-modal-idea>
        
    <!-- Filtro -->
    <x-ideas-filter 
        :selectedStatus="$selectedStatus" 
        event='filter-changed'
    />

    <!-- Exibição das Ideias -->
    <div class="w-full py-6">
        <div class="w-[90vw] max-w-[90vw] mx-auto grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse ($this->ideas as $idea)
            <a href="{{ route('ideas.show', $idea->id) }}" class="block no-underline">
                <livewire:idea.card :idea="$idea" :key="$idea->id" />
            </a>
            @empty
            <div class="col-span-2 p-8 text-center border border-dashed border-neutral-800 rounded-xl text-neutral-500">
                Nenhuma ideia encontrada para o status selecionado.
            </div>
        @endforelse
        </div>
    </div>
</div>