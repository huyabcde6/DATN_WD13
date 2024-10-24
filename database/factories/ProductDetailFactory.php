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
            'products_id' => products::inRandomOrder()->first()->id,
            'size_id' => Size::inRandomOrder()->first()->size_id,
            'color_id' => Color::inRandomOrder()->first()->color_id,
            'image' => $this->faker->imageUrl(),
            'is_active' => $this->faker->boolean(),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'discount_price' => $this->faker->randomFloat(2, 5, 90),
            'quantity' => $this->faker->numberBetween(1, 100),
            'product_code' => $this->faker->unique()->regexify('[A-Z0-9]{8}'), 
        ];
    }

}
