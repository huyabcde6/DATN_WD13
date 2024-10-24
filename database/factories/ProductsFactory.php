<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\categories;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\products>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\products::class;
    
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'categories_id' => categories::factory(),
            'avata' => $this->faker->imageUrl(),
            'description' => $this->faker->paragraph,
            'iS_hot' => $this->faker->boolean,
            'iS_new' => $this->faker->boolean,
            'iS_show' => $this->faker->boolean,
        ];
    }
}
