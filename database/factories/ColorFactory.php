<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Color;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\color>
 */
class ColorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Color::class;

    public function definition(): array
    {
        return [
            'valu' => $this->faker->safeColorName(),
            'status' => $this->faker->boolean(),
        ];
    }
}
