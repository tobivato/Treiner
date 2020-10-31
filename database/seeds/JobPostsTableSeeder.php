<?php

use Illuminate\Database\Seeder;

class JobPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Treiner\JobPost::class, 100)->create();
    }
}
