<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class IdeaController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validateIdea($request);

        $imagePath = null;
        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('ideas', 'public');
        }

        DB::transaction(function () use ($validated, $imagePath) {
            $idea = Idea::create([
                'user_id'     => Auth::id(),
                'title'       => $validated['title'],
                'description' => $validated['description'] ?? null,
                'start_date'  => $validated['start_date'] ?? null,
                'image_path'  => $imagePath,
                'status'      => $validated['status'],
                'links'       => array_filter($validated['links'] ?? []),
            ]);

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
     * Valida os dados enviados pela requisição da ideia.
     */
    private function validateIdea(Request $request): array
    {
        return $request->validate([
            'title'               => 'required|string|max:255',
            'description'         => 'nullable|string',
            'start_date'          => 'nullable|string|max:255',
            'image_path'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
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
        if ($idea->user_id !== Auth::id()) {
            abort(403, 'Ação não autorizada.');
        }

        $validated = $this->validateIdea($request);

        $imagePath = $idea->image_path;

        // Se o usuário clicou na lixeira para remover a imagem existente
        if ($request->boolean('remove_image')) {
            if ($idea->image_path) {
                Storage::disk('public')->delete($idea->image_path);
            }
            $imagePath = null;
        }

        // dd(request()->all());

        // Se enviou uma nova imagem (via drag & drop ou clique no campo)
        if ($request->hasFile('image_path')) {
            if ($idea->image_path) {
                Storage::disk('public')->delete($idea->image_path);
            }
            $imagePath = $request->file('image_path')->store('ideas', 'public');
        }

        DB::transaction(function () use ($idea, $validated, $imagePath) {
            $idea->update([
                'title'       => $validated['title'],
                'description' => $validated['description'] ?? null,
                'image_path'  => $imagePath,
                'status'      => $validated['status'],
                'links'       => array_filter($validated['links'] ?? []),
            ]);

            // Sincronização dos passos
            if (isset($validated['steps'])) {
                $keptIds = [];
                foreach ($validated['steps'] as $stepData) {
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
                $idea->steps()->whereNotIn('id', $keptIds)->delete();
            } else {
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

        if ($idea->image_path) {
            Storage::disk('public')->delete($idea->image_path);
        }

        $idea->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Ideia deletada com sucesso!');
    }
}