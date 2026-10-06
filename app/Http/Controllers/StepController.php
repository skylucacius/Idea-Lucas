<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Step;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StepController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'idea_id'     => 'required|exists:ideas,id',
            'description' => 'required|string|max:255',
            'completed'   => 'nullable|boolean',
        ]);

        $idea = Idea::findOrFail($validated['idea_id']);

        if ($idea->user_id !== Auth::id()) {
            abort(403, 'Ação não autorizada.');
        }

        $step = $idea->steps()->create([
            'description' => $validated['description'],
            'completed'   => $validated['completed'] ?? false,
        ]);

        return redirect()->back()->with('success', 'Passo criado com sucesso!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Step $step)
    {
        if ($step->idea->user_id !== Auth::id()) {
            abort(403, 'Ação não autorizada.');
        }

        $validated = $request->validate([
            'description' => 'sometimes|required|string|max:255',
            'completed'   => 'sometimes|boolean',
        ]);

        $step->update($validated);

        // Se for requisição AJAX (Fetch), retorna resposta JSON
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'step'    => $step,
            ]);
        }

        return redirect()->back()->with('success', 'Passo atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Step $step)
    {
        if ($step->idea->user_id !== Auth::id()) {
            abort(403, 'Ação não autorizada.');
        }

        $step->delete();

        return redirect()->back()->with('success', 'Passo removido com sucesso!');
    }
}