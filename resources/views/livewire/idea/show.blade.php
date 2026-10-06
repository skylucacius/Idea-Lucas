<?php

use App\Concerns\WithIdeaFilter;
use Illuminate\Support\Facades\Auth;
use function Livewire\Volt\{state, mount, uses};

state(['idea']);
uses(WithIdeaFilter::class);

mount(function ($id) {
    /** @var \App\Models\User $user */
    $user = Auth::user();
    $this->idea = $user->ideas()->findOrFail($id);
});

?>

<div class="max-w-4xl mx-auto py-8 px-4 space-y-6">
    {{-- Cabeçalho com Ações --}}
    <div class="flex items-center justify-between">
        <flux:button href="{{ route('dashboard') }}" icon="arrow-left" variant="ghost" wire:navigate>
            Voltar a dashboard
        </flux:button>

        <div class="flex items-center gap-2">
            <flux:button icon="pencil-square" variant="subtle" wire:navigate
                @click="$dispatch('open-modal')"
            >
                Editar
            </flux:button>
            <form action="{{ route('ideas.destroy', $idea) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <flux:button variant="ghost" icon="trash" type="submit" class="!text-zinc-400 hover:!text-red-400 transition-colors">
                    Deletar
                </flux:button>
            </form>
        </div>
    </div>

    {{-- Título da Ideia --}}
    <h1 class="text-4xl font-bold text-zinc-900 dark:text-white">
        {{ $idea->title }}
    </h1>

    {{-- Status e Tempo decorrido --}}
    <div class="flex items-center gap-3 text-sm text-zinc-500 dark:text-zinc-400">
        <flux:badge :color="match($idea->status) {
            'completed' => 'green',
            'in_progress' => 'blue',
            default => 'yellow',
        }">
            {{ ucfirst(str_replace('_', ' ', $idea->status->value)) }}
        </flux:badge>

        <span>{{ $idea->created_at->diffForHumans() }}</span>
    </div>

    {{-- Descrição --}}
    <flux:card class="bg-zinc-900/50 border-zinc-800 text-zinc-300 p-6 rounded-xl">
        <p class="leading-relaxed">
            {{ $idea->description }}
        </p>
    </flux:card>

    {{-- Modal inicialmente invisível para criar/editar ideias --}}
    <x-modal-idea>
        <x-save-idea-form :idea="$idea" />
    </x-modal-idea>


    <x-idea-links :links="$idea->links" />

</div>