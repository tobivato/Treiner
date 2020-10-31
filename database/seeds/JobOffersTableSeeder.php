<?php

use Illuminate\Database\Seeder;

class JobOffersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Treiner\JobOffer::class, 50)->create();
    }
}
