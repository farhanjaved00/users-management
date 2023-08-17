<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'update profile']);
        Permission::create(['name' => 'delete account']);

        // this can be done as separate statements
        $role = Role::create(['name' => 'manager']);
        $role->givePermissionTo('update profile');
        $role->givePermissionTo('delete account');


        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());

        $users = User::all();
        foreach($users as $user) {
            if($user->name !== 'dummy_user')
                $user->assignRole($user->name);
        }
    }
}
