<?php

use Illuminate\Support\Facades\Auth;
use function Livewire\Volt\{state, mount};

state(['idea']);

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
            Back to Ideas
        </flux:button>

        <div class="flex items-center gap-2">
            <flux:button href="{{ route('dashboard', $idea->id) }}" icon="pencil-square" variant="subtle" wire:navigate>
                Edit Idea
            </flux:button>
            <flux:button wire:click="delete" variant="danger" icon="trash">
                Delete
            </flux:button>
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

    {{-- Seção de Links --}}
    @if(!empty($idea->links))
        <div class="space-y-3 pt-4">
            <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">
                Links
            </h2>

            <div class="space-y-2">
                @php
                    $links = $idea->links
                @endphp

                @foreach($links as $link)
                    <flux:card class="bg-zinc-900/50 border-zinc-800 hover:border-zinc-700 transition p-4 rounded-xl">
                        <a href="{{ $link }}" class="flex items-center gap-2 text-emerald-500 hover:underline break-all">
                            <flux:icon icon="arrow-top-right-on-square" class="size-4 shrink-0" />
                            <span>{{ $link }}</span>
                        </a>
                    </flux:card>
                @endforeach
            </div>
        </div>
    @endif
</div>
