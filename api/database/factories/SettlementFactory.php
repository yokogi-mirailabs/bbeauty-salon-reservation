<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Settlement>
 */
class SettlementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // 'user_id',
        // 'reservation_id',
        // 'payjp_card_id',
        // 'payjp_charge_id',
        // 'payment_amount',
        // 'payment_result',
        $payjpChargeId = 'ch_3eac1100997f20bb300d0bb9c74df';
        $payjpCardId = 'car_034f237cc47ff13e802fce8e1185';
        return [
            'payjp_card_id' => $payjpCardId,
            'payjp_charge_id' => $payjpChargeId,
            'payment_date' => $this->faker->dateTime(),
            'payment_amount' => $this->faker->numberBetween(1000, 10000),
            'payment_result' => true,
        ];
    }
}
