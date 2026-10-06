@props([
    'steps' => [],
    'action' => 'view'
])

@php
    // Normaliza para array de arrays com id, description e completed
    $stepsArray = collect($steps)->map(function ($step) {
        if (is_array($step)) {
            return [
                'id' => $step['id'] ?? null,
                'description' => $step['description'] ?? '',
                'completed' => (bool) ($step['completed'] ?? false),
            ];
        }
        return [
            'id' => $step->id ?? null,
            'description' => $step->description ?? '',
            'completed' => (bool) ($step->completed ?? false),
        ];
    })->values()->toArray();

    // Se NÃO for modo de visualização (ex: create ou update) e não houver passos, inicia com 1 campo em branco
    if ($action !== 'view' && empty($stepsArray)) {$stepsArray = [['id' => null, 'description' => '', 'completed' => false]];
    }
@endphp

<div 
    x-data="{ 
        steps: {{ json_encode($stepsArray) }},
        addStep() {
            this.steps.push({ id: null, description: '', completed: false });
        },
        removeStep(index) {
            this.steps.splice(index, 1);
            if (this.steps.length === 0 && '{{ $action }}' !== 'view') {
                this.addStep();
            }
        },
        async toggleStep(index) {
            const step = this.steps[index];
            
            // Inverte o estado local para feedback imediato
            step.completed = !step.completed;

            // Persiste no banco apenas se for modo view e o passo tiver ID
            if ('{{ $action }}' === 'view' && step.id) {
                try {
                    const response = await fetch(`/steps/${step.id}`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            completed: step.completed
                        })
                    });

                    if (!response.ok) {
                        step.completed = !step.completed;
                        console.error('Falha ao atualizar o estado do passo.');
                    }
                } catch (error) {
                    step.completed = !step.completed;
                    console.error('Erro de conexão ao atualizar o passo:', error);
                }
            }
        }
    }" 
    class="space-y-3 pt-4"
>
    <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">
        Passos
    </h2>

    {{-- MODO 1: Visualização / Checklist Interativo --}}
    @if($action === 'view')
        <div class="space-y-2.5">
            <template x-for="(step, index) in steps" :key="index">
                <!-- Adicionado @click.stop.prevent para EVITAR o submit do formulário da página -->
                <div 
                    @click.stop.prevent="toggleStep(index)"
                    class="flex items-center gap-3 w-full p-4 rounded-xl border bg-zinc-900/50 border-zinc-800 hover:border-zinc-700 cursor-pointer transition select-none"
                >
                    <!-- Ícone do Checklist -->
                    <div 
                        class="size-5 rounded-full flex items-center justify-center border transition-all duration-200 shrink-0"
                        :class="step.completed 
                            ? 'bg-emerald-500 border-emerald-500 text-zinc-950' 
                            : 'border-zinc-700 hover:border-emerald-500/50'"
                    >
                        <svg x-show="step.completed" class="w-3.5 h-3.5 stroke-[3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>

                    <!-- Texto do Passo -->
                    <span 
                        x-text="step.description"
                        class="text-sm font-medium transition-all duration-200 break-all"
                        :class="step.completed 
                            ? 'line-through text-zinc-500' 
                            : 'text-zinc-200'"
                    ></span>
                </div>
            </template>

            <template x-if="steps.length === 0">
                <p class="text-sm text-zinc-500 italic">Nenhum passo cadastrado.</p>
            </template>
        </div>

    {{-- MODO 2: Edição e Criação --}}
    @else
        <div class="space-y-2.5">
            <template x-for="(step, index) in steps" :key="index">
                <div class="flex items-center gap-2 w-full">
                    <template x-if="step.id">
                        <input type="hidden" :name="`steps[${index}][id]`" :value="step.id">
                    </template>
                    <input type="hidden" :name="`steps[${index}][completed]`" :value="step.completed ? 1 : 0">

                    <div class="relative flex-1">
                        <input
                            type="text"
                            :name="`steps[${index}][description]`"
                            x-model="step.description"
                            placeholder="Descreva o passo..."
                            class="w-full bg-[#121215] border border-zinc-800 rounded-lg px-3.5 py-2.5 text-sm text-zinc-100 placeholder-zinc-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition"
                        />
                    </div>

                    <flux:button 
                        type="button"
                        @click="removeStep(index)"
                        variant="ghost" 
                        icon="trash" 
                        square 
                        aria-label="Deletar passo" 
                        class="text-red-500 hover:text-red-400 hover:bg-red-500/10 hover:border hover:border-red-500/30 hover:scale-110 active:scale-95 transition-all duration-200 shadow-sm hover:shadow-red-500/20 shrink-0"
                    />
                </div>
            </template>
        </div>

        <button
            type="button"
            @click="addStep()"
            class="inline-flex items-center gap-2 text-xs font-medium text-emerald-500 hover:text-emerald-400 hover:underline pt-1 transition-colors"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Adicionar outro passo</span>
        </button>

        @error('steps')
            <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span>
        @enderror
    @endif
</div>