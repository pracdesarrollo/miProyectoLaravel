<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // El orden es importante para evitar errores de llaves foráneas.
        // Primero, creamos los roles y los usuarios.
        $this->call(RolesAndPermissionsSeeder::class);
        
        // Luego, los productos, que son necesarios para las ventas.
        $this->call(ProductSeeder::class);

        // Finalmente, las ventas, ya que dependen de los productos y usuarios.
        $this->call(SaleSeeder::class);

        // Opcional: Crear usuarios adicionales de prueba
        User::factory(20)->create();
    }
}