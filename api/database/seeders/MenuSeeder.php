<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Shop;
use App\Models\Stylist;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shop = Shop::first();
        $menus = Menu::factory()
            ->for($shop)
            ->createMany([
                [
                    'name' => 'カラー',
                    'price' => 10000,
                ],
                [
                    'name' => 'パーマ',
                    'price' => 12000,
                ],
                [
                    'name' => '縮毛矯正',
                    'price' => 15000,
                ],
                [
                    'name' => 'トリートメント',
                    'price' => 5000,
                ],
                [
                    'name' => 'ヘッドスパ',
                    'price' => 5000,
                ]
            ]);
    }
}
