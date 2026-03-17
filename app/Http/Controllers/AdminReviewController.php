<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Notifications\ReviewModeradaNotification;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');

        $reviews = Review::with(['livro', 'user'])
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(10);

        return view('admin.reviews.index', compact('reviews', 'status'));
    }

    public function show(Review $review)
    {
        $review->load(['livro', 'user']);
        return view('admin.reviews.show', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        $request->validate([
            'estado' => 'required|in:suspenso,ativo,recusado',
            'justificacao' => 'nullable|string|max:2000',
        ]);

        if ($request->estado === 'recusado' && blank($request->justificacao)) {
            return back()->withErrors([
                'justificacao' => 'A justificação é obrigatória quando a review é recusada.',
            ])->withInput();
        }

        $review->update([
            'estado' => $request->estado,
            'justificacao' => $request->estado === 'recusado' ? $request->justificacao : null,
            'moderado_em' => now(),
        ]);

        $review->user->notify(new \App\Notifications\ReviewModeradaNotification($review));

        return redirect()
            ->route('admin.reviews.show', $review)
            ->with('success', 'Review moderada com sucesso.');
    }
}
