<?php

namespace Database\Factories;

use App\Models\ProductDetail;
use App\Models\products;
use App\Models\Size;
use App\Models\Color;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\productDetail>
 */
class ProductDetailFactory extends Factory
{   
    protected $model = ProductDetail::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'products_id' => products::factory(),
            'sizes_id' => Size::factory(),
            'color_id' => Color::factory(),
            'image' => $this->faker->imageUrl(),
            'is_active' => $this->faker->boolean(),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'quantity' => $this->faker->numberBetween(1, 100), 
        ];
    }
}
