<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_admin = Role::create(['name' => 'admin']);
        $role_standard = Role::create(['name' => 'standard']);

        $permission_read = Permission::create(['name' => 'read tasks']);
        $permission_edit = Permission::create(['name' => 'edit tasks']);
        $permission_write = Permission::create(['name' => 'create tasks']);
        $permission_delete = Permission::create(['name' => 'delete tasks']);

        $permissions_admin = [$permission_read, $permission_edit, $permission_write, $permission_delete];
        $permissions_standard = [$permission_read, $permission_write];

        $role_admin->syncPermissions($permissions_admin);
        $role_standard->syncPermissions($permissions_standard);

    }
}
