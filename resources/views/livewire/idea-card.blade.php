<?php

use function Livewire\Volt\{state};

state(['idea']);

?>

<div class="rounded-xl border border-neutral-800 bg-neutral-900 p-6 text-neutral-200 shadow-sm">
    <h3 class="text-lg font-semibold text-white">
        {{ $idea['title'] ?? $idea->title }}
    </h3>

<div class="mt-2">
    <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-medium backdrop-blur-md {{ $idea->status->badgeClasses() }}">
        {{ $idea->status->label() }}
    </span>
</div>
    <p class="mt-4 text-sm text-neutral-400">
        {{ $idea['description'] ?? $idea->description }}
    </p>

    <div class="mt-6 text-xs text-neutral-500">
        {{ isset($idea->created_at) ? $idea->created_at->diffForHumans() : ($idea['created_at'] ?? 'Há um tempo indeterminado') }}
    </div>
</div>
