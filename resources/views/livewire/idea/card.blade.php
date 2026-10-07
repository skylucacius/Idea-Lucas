<?php

use function Livewire\Volt\{state};

state(['idea']);

$updateStatus = function (string $newStatus) {
    $this->idea->update([
        'status' => $newStatus,
    ]);
};

?>

<div class="bg-zinc-900 border border-zinc-800 hover:bg-zinc-800/80 hover:border-zinc-700 hover:shadow-lg transition-all duration-200 rounded-xl cursor-pointer overflow-hidden flex flex-col h-full group">
    
    {{-- Container da Imagem com altura proporcional e reduzida --}}
    @if ($idea->image_path)
        <div class="w-full h-44 sm:h-48 bg-zinc-950 overflow-hidden border-b border-zinc-800/80 relative">
            <img 
                src="{{ asset('storage/' . $idea->image_path) }}" 
                alt="{{ $idea->title }}" 
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
            />
        </div>
    @endif

    {{-- Conteúdo do Card mais compacto --}}
    <div class="p-4 flex flex-col justify-between flex-1 space-y-2">
        <div>
            <h3 class="text-base font-semibold text-white group-hover:text-emerald-400 transition-colors line-clamp-1">
                {{ $idea->title }}
            </h3>

            <div class="mt-1.5">
                <x-idea-status-badge :status="$idea->status" />
            </div>

            <p class="mt-2 text-xs text-neutral-400 line-clamp-2">
                {{ $idea->description }}
            </p>
        </div>

        <div class="mt-3 text-[11px] text-neutral-500 border-t border-neutral-800/60 pt-3">
            {{ $idea->created_at?->diffForHumans() ?? 'Há um tempo indeterminado' }}
        </div>
    </div>
</div>