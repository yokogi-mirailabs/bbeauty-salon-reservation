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
                    'job_post' => 0,
                    'speciality' => 'カラー',
                ],
                [
                    'job_post' => 0,
                    'speciality' => 'パーマ',
                ],
                [
                    'job_post' => 0,
                    'speciality' => '縮毛矯正',
                ],
                [
                    'job_post' => 1,
                    'speciality' => 'トリートメント',
                ],
                [
                    'job_post' => 2,
                    'speciality' => 'ヘッドスパ',
                ],
            ]);
    }
}
