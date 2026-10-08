@use('App\Enums\IdeaStatus')
@props([
    'selectedStatus' => 'pending',
    'event' => 'filter-changed'
])

<div class="mt-10 mb-10">
    <div class="grid {{ $event === 'filter-changed' ? 'grid-cols-4' : 'grid-cols-3' }} gap-4">

        @foreach (IdeaStatus::cases() as $statusCase)
            <x-status-button
                :status-case="$statusCase"
                :selected-status="$selectedStatus"
                @click="$dispatch('{{ $event }}', { status: '{{ $statusCase->value }}' }); selectedStatus = '{{ $statusCase->value }}'"
            />
        @endforeach

        @if ($event === 'filter-changed')
            <x-status-button
                label="Todas"
                :selected-status="$selectedStatus"
                @click="$dispatch('{{ $event }}', { status: 'All' }); selectedStatus = 'All'"
            />
        @endif
    </div>
</div>