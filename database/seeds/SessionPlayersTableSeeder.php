<?php

use Illuminate\Database\Seeder;

class SessionPlayersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $player_arr = DB::table('players')->pluck('id')->toArray();
        $session_arr = DB::table('sessions')->pluck('id')->toArray();
        $payment_arr = DB::table('payments')->pluck('id')->toArray();
        $pairs = array();

        while (sizeof($pairs) < sizeof($payment_arr)) {
            $pair = array(Arr::random($player_arr), Arr::random($session_arr));
            if (in_array($pair, $pairs) == false) {
                array_push($pairs, $pair);
            }
        }

        $player_count = random_int(1, 10);
        $players = [];

        for ($i=0; $i < $player_count; $i++) { 
            array_push($players, [
                 'name' => "John Smith", 
                 'age' => 21, 
                 'medical' => 'Lorem ipsum etc blah',
            ]);
        }

        for ($index = 0; $index < sizeof($payment_arr); $index++) {
            DB::table('session_players')->insert([
                'payment_id' => $payment_arr[$index],
                'player_id' => $pairs[$index][0],
                'session_id' => $pairs[$index][1],
                'player_info' => json_encode($players),
                'review_email_sent' => 1,
                'players' => $player_count,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
    }
}
