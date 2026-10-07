@props(['idea' => null])


<form
    action="{{ $idea ? route('ideas.update', $idea) : route('ideas.store') }}"
    method="POST"
    enctype="multipart/form-data"
    class="space-y-5 text-left"
>
    @csrf

    @if ($idea)
        @method('PUT')
    @endif

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
            class="w-full bg-[#121215] border border-emerald-500 rounded-lg px-3.5 py-2.5 text-sm text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition"
        />
        @error('title')
            <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <!-- Status -->
    <div>
        <x-ideas-filter
            :selected-status="old('status', $this->selectedStatus2)"
            event="modal-changed"
        />
        {{  $this->selectedStatus2 }}
        <input type="hidden" name="status" value="{{ old('status', $this->selectedStatus2) }}" />
    </div>

    <!-- Descrição -->
    <div>
        <label for="description" class="block text-sm font-medium text-zinc-300 mb-1.5">
            Descrição
        </label>
        <textarea
            name="description"
            id="description"
            rows="4"
            placeholder="Descreva sua ideia..."
            required
            class="w-full bg-[#121215] border border-zinc-800 rounded-lg px-3.5 py-2.5 text-sm text-zinc-100 placeholder-zinc-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition resize-none"
        >{{ old('description', $idea?->description) }}</textarea>
        @error('description')
            <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <!-- Imagem com Drag & Drop e Lixeira -->
    <div 
        x-data="{ 
            isDragging: false,
            previewUrl: '{{ $idea?->image_path ? asset('storage/' . $idea->image_path) : '' }}',
            removeImage: false,
            handleFileSelect(e) {
                const file = e.target.files[0];
                if (file) {
                    this.previewUrl = URL.createObjectURL(file);
                    this.removeImage = false;
                }
            },
            handleDrop(e) {
                this.isDragging = false;
                const file = e.dataTransfer.files[0];
                if (file && file.type.startsWith('image/')) {
                    this.$refs.fileInput.files = e.dataTransfer.files;
                    this.previewUrl = URL.createObjectURL(file);
                    this.removeImage = false;
                }
            },
            clearImage() {
                this.previewUrl = '';
                this.$refs.fileInput.value = '';
                this.removeImage = true;
            }
        }"
    >
        <label class="block text-sm font-medium text-zinc-300 mb-1.5">
            Imagem
        </label>

        <!-- Flag oculta para indicar remoção no envio do formulário -->
        <input type="hidden" name="remove_image" :value="removeImage ? '1' : '0'">

        <!-- Previsualização com Lixeira -->
        <template x-if="previewUrl">
            <div class="flex items-center gap-3 mb-3">
                <div class="relative w-32 h-32 rounded-xl overflow-hidden border border-zinc-800 bg-[#121215] shrink-0">
                    <img :src="previewUrl" class="w-full h-full object-cover">
                </div>

                <flux:button 
                    type="button"
                    @click="clearImage()"
                    variant="ghost" 
                    icon="trash" 
                    square 
                    aria-label="Remover imagem" 
                    class="text-red-500 hover:text-red-400 hover:bg-red-500/10 hover:border hover:border-red-500/30 hover:scale-110 active:scale-95 transition-all duration-200 shadow-sm hover:shadow-red-500/20 shrink-0"
                />
            </div>
        </template>

        <!-- Área Drag and Drop (Dropzone) -->
        <div
            x-show="!previewUrl"
            @dragover.prevent="isDragging = true"
            @dragleave.prevent="isDragging = false"
            @drop.prevent="handleDrop($event)"
            @click="$refs.fileInput.click()"
            :class="isDragging ? 'border-emerald-500 bg-emerald-500/5' : 'border-zinc-800 bg-[#121215] hover:border-zinc-700'"
            class="border-2 border-dashed rounded-xl p-6 text-center cursor-pointer transition-all duration-200 flex flex-col items-center justify-center gap-2"
        >
            <svg class="w-8 h-8 text-zinc-500 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <p class="text-xs text-zinc-400 font-medium">
                Arraste e solte uma imagem aqui, ou <span class="text-emerald-500 hover:underline">clique para buscar</span>
            </p>
            <p class="text-[10px] text-zinc-500">PNG, JPG ou WEBP (Max. 2MB)</p>

            <input
                x-ref="fileInput"
                type="file"
                name="image_path"
                id="image_path"
                accept="image/png, image/jpeg, image/webp"
                class="hidden"
                @change="handleFileSelect($event)"
            />
        </div>

        @error('image_path')
            <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <!-- Links -->
    <x-idea-links :links="old('links', $idea->links ?? [] )" :action="$idea ? 'update' : 'create'" />
        
    <!-- Passos -->
    <x-idea-steps :steps="$idea?->steps ?? []" :action="$idea ? 'update' : 'create'"/>

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