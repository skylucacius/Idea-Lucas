<?php

use function Livewire\Volt\{state};

state(['idea']);

$updateStatus = function (string $newStatus) {
    $this->idea->update([
        'status' => $newStatus,
    ]);
    };

    ?>


{{-- <div class="rounded-xl border border-neutral-800 bg-neutral-900 p-6 text-neutral-200 shadow-sm"> --}}
<div class="rounded-xl border border-neutral-800/80 bg-neutral-900/80 p-6 text-neutral-200 shadow-lg backdrop-blur-md transition-all duration-300">
    <h3 class="text-lg font-semibold text-white">
        {{ $idea->title }}
    </h3>

    <div class="mt-2">
    <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-medium backdrop-blur-md {{ $idea->status->badgeClasses() }}">
        {{ $idea->status->label() }}
    </span>
    </div>

    <p class="mt-3 text-sm text-neutral-400">
        {{ $idea->description }}
    </p>

    <div class="mt-6 text-xs text-neutral-500 border-t border-neutral-800/60 pt-4">
        {{ $idea->created_at?->diffForHumans() ?? 'Há um tempo indeterminado' }}
    </div>
</div>
