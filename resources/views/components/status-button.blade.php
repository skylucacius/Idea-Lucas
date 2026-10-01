@props([
    'statusCase' => null,
    'label' => null,
    'isActive' => false,
])

@php
    $buttonLabel = $label ?? $statusCase?->label() ?? '';
    $classes = $isActive
        ? ($statusCase ? $statusCase->badgeClasses() . ' shadow-lg scale-105 ring-1 ring-white/10' : 'bg-neutral-800 text-white border-neutral-700 shadow-lg scale-105')
        : ($statusCase ? $statusCase->inactiveClasses() : 'bg-neutral-900/40 text-neutral-400 border-neutral-800 hover:bg-neutral-800/50 hover:text-neutral-200');
@endphp

<button
    type="button"
    {{ $attributes }}
    x-data="{ active: @json($isActive) }"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-95"
    class="relative flex flex-col items-center justify-center p-3 rounded-lg border text-xs font-medium backdrop-blur-sm transition-all duration-300 transform active:scale-95 cursor-pointer {{ $classes }}"
>
    <span>{{ $buttonLabel }}</span>

    {{-- <!-- Indicador visual do status ativo -->
    @if ($isActive)
        <span class="absolute -top-1 -right-1 flex h-2.5 w-2.5">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-current opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-current"></span>
        </span>
    @endif --}}
</button>
