<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    public function definition()
    {
        $product = Product::inRandomOrder()->first();
        $quantity = fake()->numberBetween(1, 5);
        
        return [
            'product_id' => $product?->id ?? Product::factory(),
            'user_id' => fake()->optional()->randomElement(User::pluck('id')->toArray()),
            'quantity' => $quantity,
            'sale_date' => fake()->dateTimeBetween('-1 year', 'now'),
            'total_price' => $product ? $product->price * $quantity : fake()->randomFloat(2, 10, 500),
        ];
    }
}