@use('App\Enums\IdeaStatus')
@props(['selectedStatus' => 'All'])

<div class="mt-10">
    {{-- <span class="text-sm font-bold text-neutral-400 block mb-2">Alterar Status:</span> --}}
    <div class="grid grid-cols-4 gap-4">

        @foreach (IdeaStatus::cases() as $statusCase)
            @php
                $isActive = $selectedStatus === $statusCase->value;
            @endphp

            <x-status-button
            wire:click="$dispatch('filter-changed', { status: '{{ $statusCase->value }}' })"
            :status-case="$statusCase"
            :is-active="$isActive"
            {{-- wire:click="statusSelection('{{ $statusCase->value }}')" --}}
            />
        @endforeach

            <x-status-button
                label="Todas"
                :is-active="$selectedStatus === 'All'"
                {{-- wire:click="statusSelection('All')" --}}
                wire:click="$dispatch('filter-changed', { status: 'All' })"
                />
    </div>
</div>