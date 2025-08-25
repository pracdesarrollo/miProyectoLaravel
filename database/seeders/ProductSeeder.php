<?php 


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
