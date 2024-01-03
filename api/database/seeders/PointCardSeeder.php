<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shop;
use App\Models\User;
use App\Models\PointCard;

class PointCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shop = Shop::first();
        $user = User::first();
        PointCard::factory()->create([
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'point' => 0,
        ]);
    }
}
