<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\categories;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\categories>
 */
class CategoriesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'gioi_tinh' => $this->faker->randomElement(['Nam', 'Nữ']),
            'name' => $this->faker->word(),
            'status' => $this->faker->boolean(),
        ];
    }
}
