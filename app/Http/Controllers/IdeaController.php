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
                'end_date'    => $validated['end_date'] ?? null,
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

    private function validateIdea(Request $request): array
    {
        $todayBr = now()->format('d/m/Y');

        // Regra flexível que permite ambos os formatos
        $dateFormatRule = 'nullable|date_format:d/m/Y H:i,d/m/Y';

        $validated = $request->validate([
            'title'               => 'required|string|max:255',
            'description'         => 'nullable|string',
            'start_date'          => "{$dateFormatRule}|after_or_equal:{$todayBr}",
            'end_date'            => "{$dateFormatRule}|before_or_equal:{$todayBr}",
            'image_path'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status'              => 'required|string|in:pending,in_progress,completed',
            'links'               => 'nullable|array',
            'links.*'             => 'nullable|url',
            'steps'               => 'nullable|array',
            'steps.*.id'          => 'nullable|exists:steps,id',
            'steps.*.description' => 'nullable|string|max:255',
            'steps.*.completed'   => 'nullable|boolean',
        ], [
            'start_date.after_or_equal' => "O campo data de início deve conter uma data posterior ou igual a {$todayBr}.",
            'end_date.before_or_equal'  => "O campo data de término deve conter uma data anterior ou igual a {$todayBr}.",
            'start_date.date_format'    => 'O campo data de início deve estar no formato dd/mm/aaaa ou dd/mm/aaaa hh:mm.',
            'end_date.date_format'      => 'O campo data de término deve estar no formato dd/mm/aaaa ou dd/mm/aaaa hh:mm.',
        ]);

        // Função auxiliar para converter o input recebido no formato ISO para a base de dados
        $parseDate = function (?string $date) {
            if (!$date) return null;

            // Se contiver horas (tem espaço e dois pontos)
            if (str_contains($date, ':')) {
                return \Illuminate\Support\Carbon::createFromFormat('d/m/Y H:i', $date)->format('Y-m-d H:i:s');
            }

            // Se for apenas a data
            return \Illuminate\Support\Carbon::createFromFormat('d/m/Y', $date)->startOfDay()->format('Y-m-d H:i:s');
        };

        if (!empty($validated['start_date'])) {
            $validated['start_date'] = $parseDate($validated['start_date']);
        }

        if (!empty($validated['end_date'])) {
            $validated['end_date'] = $parseDate($validated['end_date']);
        }

        return $validated;
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
                'start_date'  => $validated['start_date'] ?? null,
                'end_date'    => $validated['end_date'] ?? null,
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