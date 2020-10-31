<?php

declare(strict_types=1);

namespace Treiner\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Treiner\Report;
use Illuminate\View\View;
use Log;
use Treiner\Session;
use Treiner\SessionPlayer;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.reports.index', ['reports' => Report::paginate(20)]);
    }

    /**
     * Show the form for a coach to report a player.
     */
    public function createForCoach(Session $session): View
    {
        return view('dashboard.coach.report', ['session' => $session]);
    }

    /**
     * Show the form for a player to report a coach.
     */
    public function createForPlayer(SessionPlayer $session): View
    {
        return view('dashboard.player.report', ['session' => $session]);
    }

    /**
     * Stores a report from a player to a coach.
     */
    public function storeForPlayer(Request $request)
    {
        $request->validate([
            'defendant_id' => 'required|integer',
            'content' => 'required|string|max:5000',
            'session_id' => 'required|integer',
        ]);

        Report::create([
            'complainant_id' => Auth::user()->role_id,
            'complainant_type' => Auth::user()->role_type,
            'defendant_id' => $request->input('defendant_id'),
            'defendant_type' => \Treiner\Coach::class,
            'content' => $request->input('content'),
            'session_id' => $request->input('session_id'),
        ]);

        return redirect(route('home'))->with('message', 'Your report has been submitted.');
    }

    public function storeForCoach(Request $request)
    {
        $request->validate([
            'defendant_id' => 'required|integer',
            'content' => 'required|string|max:5000',
            'session_id' => 'required|integer',
        ]);

        Report::create([
            'complainant_id' => Auth::user()->role_id,
            'complainant_type' => Auth::user()->role_type,
            'defendant_id' => $request->input('defendant_id'),
            'defendant_type' => \Treiner\Player::class,
            'content' => $request->input('content'),
            'session_id' => $request->input('session_id'),
        ]);

        return redirect(route('home'))->with('message', 'Your report has been submitted.');
    }

    public function toggleResolution(Report $report)
    {
        $report->resolved = !$report->resolved;
        $report->save();

        return redirect(route('reports.index'));
    }
}
