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
        <label class="block text-sm font-medium text-zinc-300 mb-1.5">
            Status
        </label>
        <div class="grid grid-cols-3 gap-2" x-data="{ status: '{{ old('status', $idea?->status ?? 'pending') }}' }">
            <!-- Pending -->
            <label
                class="cursor-pointer text-center py-2 px-3 rounded-lg text-sm font-medium transition border border-transparent"
                :class="status === 'pending' ? 'bg-emerald-600 text-white font-semibold' : 'bg-zinc-900 text-zinc-300 hover:bg-zinc-800 border-zinc-800'"
            >
                <input type="radio" name="status" value="pending" x-model="status" class="sr-only">
                Pending
            </label>

            <!-- In Progress -->
            <label
                class="cursor-pointer text-center py-2 px-3 rounded-lg text-sm font-medium transition border border-transparent"
                :class="status === 'in_progress' ? 'bg-emerald-600 text-white font-semibold' : 'bg-zinc-900 text-zinc-300 hover:bg-zinc-800 border-zinc-800'"
            >
                <input type="radio" name="status" value="in_progress" x-model="status" class="sr-only">
                In Progress
            </label>

            <!-- Completed -->
            <label
                class="cursor-pointer text-center py-2 px-3 rounded-lg text-sm font-medium transition border border-transparent"
                :class="status === 'completed' ? 'bg-emerald-600 text-white font-semibold' : 'bg-zinc-900 text-zinc-300 hover:bg-zinc-800 border-zinc-800'"
            >
                <input type="radio" name="status" value="completed" x-model="status" class="sr-only">
                Completed
            </label>
        </div>
        @error('status')
            <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span>
        @enderror
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
            placeholder="Describe your idea..."
            required
            class="w-full bg-[#121215] border border-zinc-800 rounded-lg px-3.5 py-2.5 text-sm text-zinc-100 placeholder-zinc-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition resize-none"
        >{{ old('description', $idea?->description) }}</textarea>
        @error('description')
            <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span>
        @enderror
    </div>

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