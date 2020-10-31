<?php

namespace Treiner\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Treiner\User;
use Treiner\Http\Controllers\Controller;
use Treiner\Player;
use Log;

class PlayerController extends Controller
{
    public function showSearchForm() : View
    {
        $players = Player::paginate(25);
        return view('admin.players.search', ['players' => $players]);
    }

    public function searchById(Request $request)
    {
        return redirect(route('admin.players.show', $request->input('query')));
    }

    public function csv(Request $request)
    {
        $request->validate([
            'players' => 'required|array',
        ]);

        $players = [];
        foreach ( $request->input('players') as $playerId) {
            $player = Player::find($playerId);

            $playerArray = [
                'playerId' => $player->id,
                'userId' => $player->user->id,
                'name' => $player->user->name,
                'email' => $player->user->email,
                'dob' => $player->user->dob,
                'gender' => $player->user->gender,
                'currency' => $player->user->currency,
            ];

            array_push($players, $playerArray);
        }

        $csv = new \mnshankar\CSV\CSV();
        return $csv->fromArray($players)->render('players-' . Carbon::now()->format('c') . '.csv');
       
    }

    public function manuallyVerifyEmail(User $user)
    {
        $user->email_verified_at = Carbon::now();
        $user->save();
        return redirect()->back()->with('message', 'Email manually verified');
    }

    public function searchByName(Request $request) : View
    {
        $results = User::where('role_type', 'Treiner\Player')->get();
        
        $query = $request->input('query');

        $results = $results->reject(function($element) use ($query) {
            return mb_strpos(strtolower($element->name), strtolower($query)) === false;
        });

        return view('admin.players.results', ['results' => $results]);
    }

    public function show(Player $player) : View
    {
        return view('admin.players.show', ['player' => $player]);
    }
}
