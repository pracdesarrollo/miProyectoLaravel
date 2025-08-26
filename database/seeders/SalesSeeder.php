<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    public function run()
    {
        $products = Product::where('stock', '>', 0)->get();
        $users = User::all();

        // Crear ventas aleatorias
        for ($i = 0; $i < 100; $i++) {
            $product = $products->random();
            $user = $users->random();
            $quantity = rand(1, min(3, $product->stock));

            if ($quantity > 0) {
                Sale::create([
                    'product_id' => $product->id,
                    'user_id' => rand(0, 1) ? $user->id : null, // 50% con usuario
                    'quantity' => $quantity,
                    'sale_date' => fake()->dateTimeBetween('-6 months', 'now'),
                    'total_price' => $product->price * $quantity,
                ]);

                // Reducir stock del producto
                $product->decrement('stock', $quantity);
                $product->refresh();
            }
        }

        // Crear algunas ventas recientes (últimos 3 días)
        for ($i = 0; $i < 20; $i++) {
            $product = $products->where('stock', '>', 0)->random();
            $user = $users->random();
            $quantity = rand(1, min(2, $product->stock));

            if ($quantity > 0) {
                Sale::create([
                    'product_id' => $product->id,
                    'user_id' => rand(0, 1) ? $user->id : null,
                    'quantity' => $quantity,
                    'sale_date' => fake()->dateTimeBetween('-3 days', 'now'),
                    'total_price' => $product->price * $quantity,
                ]);

                $product->decrement('stock', $quantity);
                $product->refresh();
            }
        }
    }
}