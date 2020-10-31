<?php

declare(strict_types=1);

namespace Treiner\Http\Controllers;

use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Treiner\NewsletterSubscription;

class NewsletterSubscriptionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email:strict,dns,spoof,filter|max:255',
        ]);
        try {
            NewsletterSubscription::create([
                'email' => $request->input('email'),
                'unsub_token' => md5($request->input('email')),
            ]);
            return redirect(route('welcome') . '#subscription')->with('message', 'You have successfully subscribed to Treiner newsletters!');
        } catch (\Throwable $th) {
            return redirect(route('welcome') . '#subscription')->with('message', 'Subscription failed!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function unsub($unsub_token): \Illuminate\View\View
    {
        DB::transaction(function() use($unsub_token) {
            $newsletter = NewsletterSubscription::findOrFail($unsub_token);
            $newsletter->delete();
        });
        return view('static.unsubscribe');
    }
}
