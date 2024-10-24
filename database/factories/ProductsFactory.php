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
            'short_description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'discount_price' => $this->faker->randomFloat(2, 5, 900),
            'stock_quantity' => $this->faker->numberBetween(0, 100),
            'iS_hot' => $this->faker->boolean,
            'iS_new' => $this->faker->boolean,
            'iS_show' => $this->faker->boolean,
        ];       
    }
}
