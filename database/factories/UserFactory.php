<?php
// database/factories/UserFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->optional()->phoneNumber(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }
}

// database/factories/ProductFactory.php

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

// database/factories/SaleFactory.php

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

// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ProductSeeder::class,
            SaleSeeder::class,
        ]);
    }
}

// database/seeders/UserSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Usuario administrador por defecto
        User::create([
            'name' => 'Admin',
            'last_name' => 'Sistema',
            'email' => 'admin@sistema.com',
            'phone' => '555-0000',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Usuarios de prueba
        User::factory(20)->create();
    }
}

// database/seeders/ProductSeeder.php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Productos específicos de ejemplo
        $sampleProducts = [
            [
                'name' => 'Laptop HP Pavilion',
                'description' => 'Laptop HP Pavilion con procesador Intel i5, 8GB RAM, 256GB SSD',
                'price' => 799.99,
                'stock' => 15,
                'category' => 'Electrónicos',
                'exp_date' => null,
            ],
            [
                'name' => 'Camiseta Nike',
                'description' => 'Camiseta deportiva Nike Dri-FIT',
                'price' => 29.99,
                'stock' => 50,
                'category' => 'Ropa',
                'exp_date' => null,
            ],
            [
                'name' => 'Leche Entera 1L',
                'description' => 'Leche entera pasteurizada',
                'price' => 2.99,
                'stock' => 8, // Stock bajo
                'category' => 'Alimentos',
                'exp_date' => now()->addDays(5), // Próximo a vencer
            ],
            [
                'name' => 'Smartphone Samsung',
                'description' => 'Samsung Galaxy A54 5G 128GB',
                'price' => 399.99,
                'stock' => 25,
                'category' => 'Electrónicos',
                'exp_date' => null,
            ],
            [
                'name' => 'Yogurt Natural',
                'description' => 'Yogurt natural sin azúcar añadida',
                'price' => 1.99,
                'stock' => 0, // Sin stock
                'category' => 'Alimentos',
                'exp_date' => now()->subDays(2), // Vencido
            ],
        ];

        foreach ($sampleProducts as $product) {
            Product::create($product);
        }

        // Productos adicionales aleatorios
        Product::factory(45)->create();
        
        // Algunos productos con stock bajo
        Product::factory(5)->lowStock()->create();
        
        // Algunos productos vencidos
        Product::factory(3)->expired()->create();
    }
}

// database/seeders/SaleSeeder.php

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