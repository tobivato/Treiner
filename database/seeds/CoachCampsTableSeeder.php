<?php

use Illuminate\Database\Seeder;

class CoachCampsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Treiner\CoachCamp::class, 250)->create();
    }
}
