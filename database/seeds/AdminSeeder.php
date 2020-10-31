<?php

use Illuminate\Database\Seeder;
use Treiner\Image;
use Treiner\Player;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Player::create();

        DB::table('users')->insert([
            'role_id' => $role->id,
            'role_type' => 'Treiner\Player',
            'first_name' => config('treiner.admin-first'),
            'last_name' => config('treiner.admin-last'),
            'email' => config('treiner.admin-email'),
            'phone' => null,
            'gender' => 'male',
            'password' => bcrypt(config('treiner.admin-pass')),
            'currency' => 'AUD',
            'image_id' => 'profile-none',
            'dob' => '1900-01-01',
            'permissions' => 'super_admin',
            'email_verified_at' => \Carbon\Carbon::now(),
        ]);
    }
}
