<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\JobPostType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stylist>
 */
class StylistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $post = fake()->randomElement(JobPostType::cases())->value;
        return [
            'name' => fake()->name(),
            'description' => fake()->realText(50),
            // enum
            'post' => $post,
            'specialty' => fake()->realText(10),
            'working_year' => fake()->numberBetween(1, 10),
        ];
    }
}
