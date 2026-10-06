@props(['idea' => null])


<form
    action="{{ $idea ? route('ideas.update', $idea) : route('ideas.store') }}"
    method="POST" 
    class="space-y-5 text-left"
>
    @csrf

    @if ($idea)
        @method('PUT')
    @endif

    <!-- Título -->
    <div>
        <label for="title" class="block text-sm font-medium text-zinc-300 mb-1.5">
            Title
        </label>
        <input
            type="text"
            name="title"
            id="title"
            value="{{ old('title', $idea?->title) }}"
            placeholder="Alguma ideia nova..."
            required
            class="w-full bg-[#121215] border border-emerald-500 rounded-lg px-3.5 py-2.5 text-sm text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition"
        />
        @error('title')
            <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <!-- Status (Radio Group Estilizado) -->
    <div>
        <x-ideas-filter
            :selected-status="old('status', $this->selectedStatus2 ?? 'pending')"
            event="modal-changed"
        />
        <input type="hidden" name="status" value="{{ old('status', $this->selectedStatus2 ?? 'pending') }}" />
    </div>

    <!-- Descrição -->
    <div>
        <label for="description" class="block text-sm font-medium text-zinc-300 mb-1.5">
            Description
        </label>
        <textarea
            name="description"
            id="description"
            rows="4"
            placeholder="Descreva sua ideia..."
            required
            class="w-full bg-[#121215] border border-zinc-800 rounded-lg px-3.5 py-2.5 text-sm text-zinc-100 placeholder-zinc-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition resize-none"
        />{{ old('description', $idea?->description) }}</textarea>
        @error('description')
            <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <!-- Links -->
    <x-idea-links :links="old('links', $idea->links ?? [] )" :action=" $idea ? 'update' : 'create' " />
        
    <!-- Passos -->
    <x-idea-steps :steps="$idea?->steps ?? []" :action=" $idea ? 'update' : 'create' "/>


    <!-- Ações (Botão Criar / Atualizar) -->
    <div class="flex justify-end pt-3">
        <button
            type="submit"
            class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700 text-zinc-950 font-semibold text-sm rounded-lg shadow-md transition-colors"
        >
            {{ $idea ? 'Atualizar' : 'Criar' }}
        </button>
    </div>
</form>