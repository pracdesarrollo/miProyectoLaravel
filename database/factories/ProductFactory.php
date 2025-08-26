<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition()
    {
        $categories = ['Electrónicos', 'Ropa', 'Hogar', 'Deportes', 'Libros', 'Juguetes', 'Alimentos', 'Salud'];
        
        return [
            'name' => fake()->words(3, true),
            'description' => fake()->optional()->paragraph(),
            'price' => fake()->randomFloat(2, 1, 1000),
            'stock' => fake()->numberBetween(0, 100),
            'category' => fake()->randomElement($categories),
            'exp_date' => fake()->optional()->dateTimeBetween('now', '+2 years'),
        ];
    }

    public function lowStock()
    {
        return $this->state(fn (array $attributes) => [
            'stock' => fake()->numberBetween(0, 5),
        ]);
    }

    public function expired()
    {
        return $this->state(fn (array $attributes) => [
            'exp_date' => fake()->dateTimeBetween('-1 year', '-1 day'),
        ]);
    }
}