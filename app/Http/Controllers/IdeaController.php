<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validateIdea($request);

        DB::transaction(function () use ($validated) {
            $idea = Idea::create([
                'user_id'     => Auth::id(),
                'title'       => $validated['title'],
                'description' => $validated['description'] ?? null,
                'status'      => $validated['status'],
                'links'       => array_filter($validated['links'] ?? []),
            ]);

            // Cria os passos associados, ignorando os campos de texto em branco
            if (!empty($validated['steps'])) {
                foreach ($validated['steps'] as $stepData) {
                    if (!empty(trim($stepData['description'] ?? ''))) {
                        $idea->steps()->create([
                            'description' => $stepData['description'],
                            'completed'   => (bool) ($stepData['completed'] ?? false),
                        ]);
                    }
                }
            }
        });

        return redirect()->back()->with('success', 'Ideia criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Idea $idea)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Idea $idea)
    {
        //
    }

    /**
     * Valida os dados enviados pela requisição da ideia.
     */
    private function validateIdea(Request $request): array
    {
        return $request->validate([
            'title'               => 'required|string|max:255',
            'description'         => 'nullable|string',
            'status'              => 'required|string|in:pending,in_progress,completed',
            'links'               => 'nullable|array',
            'links.*'             => 'nullable|url',
            'steps'               => 'nullable|array',
            'steps.*.id'          => 'nullable|exists:steps,id',
            'steps.*.description' => 'nullable|string|max:255',
            'steps.*.completed'   => 'nullable|boolean',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Idea $idea)
    {
        // Garante que o usuário logado é o dono
        if ($idea->user_id !== Auth::id()) {
            abort(403, 'Ação não autorizada.');
        }

        $validated = $this->validateIdea($request);

        DB::transaction(function () use ($idea, $validated) {
            // Atualiza os dados da ideia
            $idea->update([
                'title'       => $validated['title'],
                'description' => $validated['description'] ?? null,
                'status'      => $validated['status'],
                'links'       => array_filter($validated['links'] ?? []),
            ]);

            // Sincroniza os passos com o banco de dados
            if (isset($validated['steps'])) {
                $keptIds = [];

                foreach ($validated['steps'] as $stepData) {
                    // Ignora itens totalmente vazios sem ID
                    if (empty(trim($stepData['description'] ?? '')) && empty($stepData['id'])) {
                        continue;
                    }

                    $step = $idea->steps()->updateOrCreate(
                        ['id' => $stepData['id'] ?? null],
                        [
                            'description' => $stepData['description'] ?? '',
                            'completed'   => (bool) ($stepData['completed'] ?? false),
                        ]
                    );

                    $keptIds[] = $step->id;
                }

                // Remove os passos que foram deletados pelo usuário na interface
                $idea->steps()->whereNotIn('id', $keptIds)->delete();
            } else {
                // Se a chave "steps" nem foi enviada, remove todos os passos
                $idea->steps()->delete();
            }
        });

        return redirect()->back()->with('success', 'Ideia atualizada com sucesso!');
    }

    /**
     * Remove uma ideia do banco de dados.
     */
    public function destroy(Request $request, Idea $idea)
    {
        if ($request->user()->id !== $idea->user_id) {
            abort(403, 'Ação não autorizada.');
        }

        $idea->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Ideia deletada com sucesso!');
    }
}