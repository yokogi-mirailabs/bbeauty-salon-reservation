<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Stylist;
use App\Models\Shop;
use App\Models\Menu;

class StylistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shop = Shop::first();
        $stylists = Stylist::factory()
            ->for($shop)
            ->afterCreating(function (Stylist $stylist) use ($shop) {
                $menus = Menu::where('shop_id', $shop->getkey())
                    ->inRandomOrder()
                    ->take(2)
                    ->get();
                $stylist->menus()->attach($menus);
            })
            ->createMany([
                [
                    'post' => 0,
                    'specialty' => 'カラー',
                ],
                [
                    'post' => 0,
                    'specialty' => 'パーマ',
                ],
                [
                    'post' => 0,
                    'specialty' => '縮毛矯正',
                ],
                [
                    'post' => 1,
                    'specialty' => 'トリートメント',
                ],
                [
                    'post' => 2,
                    'specialty' => 'ヘッドスパ',
                ],
            ]);
    }
}
