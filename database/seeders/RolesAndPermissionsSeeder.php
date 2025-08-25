<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Borrar caché de permisos antes de iniciar
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Crear todos los permisos granulares
        // Permisos de productos
        Permission::firstOrCreate(['name' => 'view products']);
        Permission::firstOrCreate(['name' => 'create products']);
        Permission::firstOrCreate(['name' => 'edit products']);

        // Permisos de usuarios
        Permission::firstOrCreate(['name' => 'view users']);
        Permission::firstOrCreate(['name' => 'create users']);
        Permission::firstOrCreate(['name' => 'edit users']);
        
        // Permisos de ventas
        Permission::firstOrCreate(['name' => 'view sales']);
        Permission::firstOrCreate(['name' => 'create sales']);
        Permission::firstOrCreate(['name' => 'delete sales']);

        // Permisos de reportes
        Permission::firstOrCreate(['name' => 'view reports']);

        // 2. Crear los roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $gerenteRole = Role::firstOrCreate(['name' => 'gerente']);
        $vendedorRole = Role::firstOrCreate(['name' => 'vendedor']);

        // 3. Asignar permisos a los roles según tus requisitos
        // El Administrador puede hacer TODO
        $adminRole->givePermissionTo(Permission::all());

        // El Gerente puede ver productos, crear usuarios, ver ventas, crear ventas y ver reportes
        $gerenteRole->givePermissionTo([
            'view products',
            'view users',
            'create users',
            'view sales',
            'create sales',
            'view reports'
        ]);
        
        // El Vendedor puede ver productos, crear ventas, ver sus propias ventas y eliminarlas
        $vendedorRole->givePermissionTo([
            'view products',
            'create sales',
            'view sales',
            'delete sales'
        ]);

        // 4. Crear un usuario de ejemplo para cada rol
        // Reiniciar la base de datos es la mejor manera de probar esto
        
        $adminUser = User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin',
            'last_name' => 'Root',
            'password' => bcrypt('password_admin'),
        ]);
        $adminUser->assignRole('admin');
        
        $gerenteUser = User::firstOrCreate([
            'email' => 'gerente@example.com',
        ], [
            'name' => 'Gerente',
            'last_name' => 'Test',
            'password' => bcrypt('password_gerente'),
        ]);
        $gerenteUser->assignRole('gerente');

        $vendedorUser = User::firstOrCreate([
            'email' => 'vendedor@example.com',
        ], [
            'name' => 'Vendedor',
            'last_name' => 'Test',
            'password' => bcrypt('password_vendedor'),
        ]);
        $vendedorUser->assignRole('vendedor');
    }
}