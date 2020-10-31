<?php

use Illuminate\Database\Seeder;

class NewsletterSubscriptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Treiner\NewsletterSubscription::class, 200)->create();
    }
}
