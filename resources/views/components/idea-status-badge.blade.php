@php
    use App\Enums\IdeaStatus;
@endphp

@props([
    'status' => IdeaStatus::PENDING
])

    <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-medium backdrop-blur-md {{ $status->badgeClasses() }}">
        {{ $status->label() }}
    </span>
