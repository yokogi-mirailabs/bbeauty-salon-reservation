<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Stylist;
use App\Models\MessageHistory;

class MessageHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $stylist = Stylist::first();
        MessageHistory::factory()
            ->count(5)
            ->sequence(fn ($sequence) => [
                'body' => "ユーザーからのメッセージ{$sequence->index}",
            ])
            ->create([
                'user_id' => $user->id,
                'stylist_id' => $stylist->id,
                'from_user' => true,
            ]);
        MessageHistory::factory()
            ->count(5)
            ->sequence(fn ($sequence) => [
                'body' => "スタイリストからのメッセージ{$sequence->index}",
            ])
            ->create([
                'user_id' => $user->id,
                'stylist_id' => $stylist->id,
                'from_user' => false,
            ]);
    }
}
