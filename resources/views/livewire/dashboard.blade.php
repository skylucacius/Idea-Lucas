<?php

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use function Livewire\Volt\{computed, state};
use App\Enums\IdeaStatus;

state(['selectedStatus' => 'All']);
$statusSelection = function ($text) {
    $this->selectedStatus = $text;
    };

$ideas = computed(function () {
    /** @var User|null $user */
    $user = Auth::user();
    $query = $user ? $user->ideas()->latest() : collect();

    // Se um status específico for selecionado (diferente de 'All'), filtra no banco de dados
    if ($this->selectedStatus !== 'All') {
        $query->where('status', $this->selectedStatus);
    }

    return $query->get();
});

?>

<div>
    <div class="mt-10">
        <span class="text-sm font-bold text-neutral-400 block mb-2">Alterar Status:</span>
        <div class="grid grid-cols-4 gap-4">

            @foreach (IdeaStatus::cases() as $statusCase)
                @php
                    $isActive = $selectedStatus === $statusCase->value;
                @endphp

                <!-- Botão extraído substituindo a sua seleção -->
                <x-status-button
                    :status-case="$statusCase"
                    :is-active="$isActive"
                    wire:click="statusSelection('{{ $statusCase->value }}')"
                />
            @endforeach

                <x-status-button
                    label="Todas"
                    :is-active="$selectedStatus === 'All'"
                    wire:click="statusSelection('All')"
                />
        </div>
    </div>

    <div class="w-full py-6">
        <div class="w-[90vw] max-w-[90vw] mx-auto grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse ($this->ideas as $idea)
            <a href="{{ route('ideas.show', $idea->id) }}" class="block no-underline">
                <livewire:idea.card :idea="$idea" :key="$idea->id" />
            </a>
            @empty
            <div class="col-span-2 p-8 text-center border border-dashed border-neutral-800 rounded-xl text-neutral-500">
                Nenhuma ideia encontrada para o status selecionado.
            </div>
        @endforelse
        </div>
    </div>
</div>
