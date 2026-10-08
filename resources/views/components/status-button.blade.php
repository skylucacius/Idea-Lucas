@props([
    'statusCase' => null,
    'label' => null,
    'selectedStatus' => 'pending',
])

@php
    $buttonLabel = $label ?? $statusCase?->label() ?? '';
    $statusValue = $statusCase ? $statusCase->value : 'All';
    
    $activeClasses = $statusCase 
        ? $statusCase->badgeClasses() . ' shadow-lg scale-105 ring-1 ring-white/10' 
        : 'bg-neutral-800 text-white border-neutral-700 shadow-lg scale-105';
        
    $inactiveClasses = $statusCase 
        ? $statusCase->inactiveClasses() 
        : 'bg-neutral-900/40 text-neutral-400 border-neutral-800 hover:bg-neutral-800/50 hover:text-neutral-200';

    // Determina o estilo estático inicial renderizado pelo PHP
    $isInitiallyActive = $selectedStatus === $statusValue;
    $initialClasses = $isInitiallyActive ? $activeClasses : $inactiveClasses;
@endphp

<button
    type="button"
    {{ $attributes }}
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100"
    class="relative flex flex-col items-center justify-center p-3 rounded-lg border text-xs font-medium backdrop-blur-sm transition-all duration-300 transform active:scale-95 cursor-pointer {{ $initialClasses }}"
    :class="{
        '{{ $activeClasses }}': selectedStatus === '{{ $statusValue }}',
        '{{ $inactiveClasses }}': selectedStatus !== '{{ $statusValue }}'
    }"
>
    <span>{{ $buttonLabel }}</span>
</button>