<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shop;
use App\Models\User;
use App\Models\Menu;
use App\Models\Reservation;

class PaymentHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shop = Shop::first();
        $user = User::first();
        $menus = Menu::where('shop_id', $shop->getkey())
            ->inRandomOrder()
            ->take(2)
            ->get();
        $reservations = Reservation::where('user_id', $user->getkey())
            ->inRandomOrder()
            ->take(2)
            ->get();
    }
}
