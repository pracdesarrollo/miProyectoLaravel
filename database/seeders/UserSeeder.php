<?php

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
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Usuarios de prueba
        User::factory(20)->create();
    }
}
