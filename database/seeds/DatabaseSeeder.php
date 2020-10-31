<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create all fake data when seeding
        if (config('app.env') != 'production') {
            $this->call(BillingAddressesTableSeeder::class);
            $this->call(LocationsTableSeeder::class);
            $this->call(UsersTableSeeder::class);
            $this->call(PaymentsTableSeeder::class);
            $this->call(SessionsTableSeeder::class);
    
            $this->call(BlogPostsTableSeeder::class);
            $this->call(NewsletterSubscriptionsTableSeeder::class);
            $this->call(CartItemsTableSeeder::class);
    
            $this->call(SessionPlayersTableSeeder::class);
            $this->call(ReviewsTableSeeder::class);
            $this->call(ReportsTableSeeder::class);

            $this->call(CampsTableSeeder::class);
            $this->call(CoachCampsTableSeeder::class);
    
            $this->call(JobPostsTableSeeder::class);
            $this->call(JobOffersTableSeeder::class);
            $this->call(CommentsTableSeeder::class);
            $this->call(VerificationDataTableSeeder::class);
            $this->call(ConversationsTableSeeder::class);
        }

        $this->call(AdminSeeder::class);
    }
}
