<?php

use Illuminate\Database\Seeder;

class ConversationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Treiner\Conversation::class, 100)->create()->each(function ($conversation) {
            factory(Treiner\Message::class, 10)->create([
                'conversation_id' => $conversation->id,
                'from_id' => $conversation->from_id,
                'to_id' => $conversation->to_id,
            ]);
        });
    }
}
