<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat permissions
        Permission::create(['name' => 'view catalog']);
        Permission::create(['name' => 'manage products']);
        Permission::create(['name' => 'view statistics']);
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'approve products']);
        Permission::create(['name' => 'manage content']);
        Permission::create(['name' => 'approve sellers']);
        Permission::create(['name' => 'view demo data']);

        // Membuat roles dan menambahkan permissions
        $role = Role::create(['name' => 'visitor']);
        $role->givePermissionTo(['view catalog']);

        $role = Role::create(['name' => 'seller']);
        $role->givePermissionTo(['view catalog', 'manage products', 'view statistics']);

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'demo_seller']);
        $role->givePermissionTo(['view catalog', 'view statistics', 'view demo data']);

        $role = Role::create(['name' => 'demo_admin']);
        $role->givePermissionTo(['view catalog', 'view statistics', 'view demo data']);
    }
}
