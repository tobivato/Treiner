<?php

namespace Treiner\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Treiner\Coach;
use Treiner\Session;

class LiveController extends Controller
{
    public function startMeeting($zoomNumber) {
        return view('live.session', ['zoomNumber' => $zoomNumber, 'signature' => $this->generateSignature($zoomNumber)]);
    }

    public function index()
    {
        if (Auth::user()->role instanceof Coach) {
            return view('dashboard.coach.live');
        }
        else {
            abort(403);
        }
    }

    public function addZoomNumber(Session $session, Request $request) 
    {
        $request->validate([
            'zoom_number' => 'required|string|max:255',
        ]);
        if ($session->coach->user != Auth::user()) {
            abort(403);
        }
        $session->zoom_number = preg_replace("/[^0-9]/", "",$request->input('zoom_number'));
        $session->save();
        return redirect()->back();
    }

    private function generateSignature ( $meeting_number)
    {
        if (Auth::user()->role instanceof Coach) {
            $role = 1;
        }
        else {
            $role = 0;
        }

        $time = time() * 1000; //time in milliseconds (or close enough)
        
        $data = base64_encode(config('zoom.key') . $meeting_number . $time . $role);
        
        $hash = hash_hmac('sha256', $data, config('zoom.secret'), true);
        
        $_sig = config('zoom.key') . "." . $meeting_number . "." . $time . "." . $role . "." . base64_encode($hash);
        
        //return signature, url safe base64 encoded
        return rtrim(strtr(base64_encode($_sig), '+/', '-_'), '=');
    }
    
}
