<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\Group;
use App\Models\Message;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin and regular users
        User::factory()->create([
            'name' => 'John Doe',
            'email' => "john@doe.com",
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        User::factory()->create([
            'name' => 'Jane Doe',
            'email' => "jane@doe.com",
            'password' => Hash::make('password'),
        ]);

        User::factory(10)->create();

        // Create groups and attach users
        for ($i = 0; $i < 5; $i++) {
            $groups = Group::factory(5)->create([
                'owner_id' => 1
            ]);

            foreach ($groups as $group) {
                $users = User::inRandomOrder()->limit(rand(2, 5))->pluck('id');
                $group->users()->attach(array_unique([1, ...$users]));
            }
        }

        // Create messages
        Message::factory(1000)->create();

        // Process messages for conversations
        $messages = Message::whereNull('group_id')->orderBy('created_at')->get();

        $conversations = $messages->groupBy(function ($message) {
            return collect([$message->sender_id, $message->receiver_id])
                ->sort()->implode('_');
        })->map(function ($groupedMessages) {
            return [
                'user_id1' => $groupedMessages->first()->sender_id,
                'user_id2' => $groupedMessages->first()->receiver_id,
                'last_message_id' => $groupedMessages->last()->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        })->values();

        Conversation::insertOrIgnore($conversations->toArray());
    }
}
