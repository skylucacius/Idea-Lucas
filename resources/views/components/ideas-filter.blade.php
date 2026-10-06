@use('App\Enums\IdeaStatus')
@props([
    'selectedStatus' => 'All',
    'event' => 'filter-changed'
    ])

<div class="mt-10">
    {{-- <span class="text-sm font-bold text-neutral-400 block mb-2">Alterar Status:</span> --}}
    <div class="grid {{ $event === 'filter-changed' ? 'grid-cols-4' : 'grid-cols-3' }} gap-4">

        @foreach (IdeaStatus::cases() as $statusCase)
            @php
                $isActive = $selectedStatus === $statusCase->value;
            @endphp

            <x-status-button
            :status-case="$statusCase"
            :is-active="$isActive"
            wire:click="$dispatch('{{ $event }}', { status: '{{ $statusCase->value }}' })"
            />
        @endforeach

        @if ($event === 'filter-changed')
            <x-status-button
                label="Todas"
                :is-active="$selectedStatus === 'All'"
                wire:click="$dispatch('{{ $event }}', { status: 'All' })"
                />
        @endif
    </div>
</div>