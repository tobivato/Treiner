<?php

use Illuminate\Database\Seeder;

class VerificationDataTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Treiner\VerificationData::class, 250)->create();
    }
}
