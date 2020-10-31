<?php

declare(strict_types=1);

namespace Treiner\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Treiner\Review;
use Treiner\Session;
use Treiner\SessionPlayer;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        //Can only access controller functions while authenticated
        $this->middleware('auth');
        $this->authorizeResource(Review::class, 'review');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'session_player_id' => 'required|integer',
            'rating' => 'required|integer|between:0,100',
            'content' => 'required|string|max:5000',
        ]);

        Review::create([
            'session_player_id' => $request->input('session_player_id'),
            'rating' => $request->input('rating'),
            'content' => $request->input('content'),
            'created_at' => \Carbon\Carbon::now(),
        ]);

        return redirect(route('sessions.index'))->with('message', 'You have successfully reviewed this session.');
    }

    public function edit(Review $review)
    {
        return view('dashboard.player.reviews.edit', ['review' => $review, 'sessionPlayer' => $review->sessionPlayer]);
    }

    public function update(Review $review, Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|between:0,100',
            'content' => 'required|string|max:5000',
        ]);

        $review->update([
            'rating' => $request->input('rating'),
            'content' => $request->input('content'),
        ]);

        return redirect(route('sessions.index'))->with('message', 'Your review has been successfully updated.');
    }
}
