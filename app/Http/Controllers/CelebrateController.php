<?php

namespace App\Http\Controllers;

use App\Models\Wish;
use Illuminate\Http\Request;

class CelebrateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        return view('celebrate');
    }

    // Save wish to DB
    public function saveWish(Request $request)
    {
        // Accept either a 'wish' or a 'message' (kind)
        $body = $request->input('wish') ?? $request->input('message');
        $kind = $request->input('kind') ?? ($request->has('message') ? 'message' : 'wish');

        $request->validate([
            'wish' => 'nullable|string|max:2000',
            'message' => 'nullable|string|max:2000',
        ]);

        if (! $body) {
            return response()->json(['error' => 'No content provided.'], 422);
        }

        $wish = Wish::create([
            'user_id' => $request->user()->id ?? 1,
            'body' => $body,
            'kind' => $kind,
        ]);

        // If this was the first 'wish' we ask for a personal message next
        if ($kind === 'wish') {
            return response()->json(['message' => 'Your wish is saved with the stars! ✨', 'next' => 'message']);
        }

        // If this was the personal message, finish
        return response()->json(['message' => 'Your personal note is saved — thank you! ✨', 'done' => true]);
    }

    public function bye()
    {
        return view('bye');
    }
}
