@props(['idea' => null])

@php
    $currentStatus = old('status', is_object($idea?->status) ? $idea->status->value : ($idea?->status ?? 'pending'));
@endphp

<form
    action="{{ $idea ? route('ideas.update', $idea) : route('ideas.store') }}"
    method="POST"
    enctype="multipart/form-data"
    class="space-y-4 text-left"
    x-data="{ 
        hasErrors: {{ $errors->any() ? 'true' : 'false' }},
        selectedStatus: '{{ $currentStatus }}'
    }"
    x-init="
        if (hasErrors) {
            $dispatch('open-modal');
        }
    "
    @modal-changed.window="selectedStatus = $event.detail.status"
>
    @csrf

    @if ($idea)
        @method('PUT')
    @endif

    <!-- Alerta Geral de Erros (Garante visualização mesmo se a div do campo estiver escondida) -->
    {{-- @if ($errors->any())
        <div class="p-3 bg-red-500/10 border border-red-500/30 rounded-lg text-xs text-red-400 space-y-1">
            <p class="font-semibold">Atenção: verifique os campos abaixo</p>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}
    <!-- Título -->
    <div>
        <label for="title" class="block text-sm font-medium text-zinc-300 mb-1.5">
            Título
        </label>
        <input
            type="text"
            name="title"
            id="title"
            value="{{ old('title', $idea?->title) }}"
            placeholder="Alguma ideia nova..."
            required
            x-effect="if (open) $nextTick(() => $el.focus())"
            class="w-full bg-[#121215] border border-emerald-500 rounded-lg px-3.5 py-2.5 text-sm text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition"
        />
        @error('title')
            <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <!-- Status -->
    <div>
        <x-ideas-filter
            x-bind:selected-status="selectedStatus"
            event="modal-changed"
        />
        <input type="hidden" name="status" :value="selectedStatus" x-ref="statusInput"/>
        @error('status')
            <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <!-- Data de início (Visível apenas se status for 'pending' ou 'in_progress') -->
    <div x-show="['pending', 'in_progress'].includes(selectedStatus)" x-transition>
        <label for="start_date" class="block text-sm font-medium text-zinc-300 mb-1.5">
            Data de início
        </label>
        <input
            type="text"
            name="start_date"
            id="start_date"
            value="{{ old('start_date', $idea?->start_date_formatted) }}"
            placeholder="15/10/2026 ou 15/10/2026 21:57"
            class="w-full bg-[#121215] border border-zinc-800 rounded-lg px-3.5 py-2.5 text-sm text-zinc-100 placeholder-zinc-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition"
        />
        @error('start_date')
            <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span>
        @enderror
    </div>
    
    <!-- Data de término (Visível apenas se status for 'completed') -->
    <div x-show="['completed'].includes(selectedStatus)" x-transition>
        <label for="end_date" class="block text-sm font-medium text-zinc-300 mb-1.5">
            Data de término
        </label>
        <input
            type="text"
            name="end_date"
            id="end_date"
            value="{{ old('end_date', $idea?->end_date_formatted) }}"
            placeholder="15/10/2026 ou 15/10/2026 21:57"
            class="w-full bg-[#121215] border border-zinc-800 rounded-lg px-3.5 py-2.5 text-sm text-zinc-100 placeholder-zinc-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition"
        />
        @error('end_date')
            <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <!-- Descrição -->
    <div>
        <label for="description" class="block text-sm font-medium text-zinc-300 mb-1.5">
            Descrição
        </label>
        <textarea
            name="description"
            id="description"
            rows="3"
            placeholder="Descreva sua ideia..."
            required
            class="w-full bg-[#121215] border border-zinc-800 rounded-lg px-3.5 py-2.5 text-sm text-zinc-100 placeholder-zinc-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition resize-none"
        >{{ old('description', $idea?->description) }}</textarea>
        @error('description')
            <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <!-- Imagem -->
    <x-idea-image-upload :image-path="old('image_path', $idea?->image_path)" />

    <!-- Links -->
    <x-idea-links :links="old('links', $idea->links ?? [] )" :action="$idea ? 'update' : 'create'" />
        
    <!-- Passos -->
    <x-idea-steps :steps="$idea?->steps ?? []" :action="$idea ? 'update' : 'create'"/>

    <!-- Ações (Botão Criar / Atualizar) -->
    <div class="sticky bottom-0 bg-[#18181b] pt-3 pb-1 mt-4 border-t border-zinc-800/60 flex justify-end">
        <button
            type="submit"
            class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700 text-zinc-950 font-semibold text-sm rounded-lg shadow-md transition-colors"
        >
            {{ $idea ? 'Atualizar' : 'Criar' }}
        </button>
    </div>
</form>