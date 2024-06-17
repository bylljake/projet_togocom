<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create user permissions.
        $user_list = Permission::create(['name' => 'list']);
        $user_view = Permission::create(['name' => 'view']);
        $user_create = Permission::create(['name' => 'create']);
        $user_update = Permission::create(['name' => 'update']);
        $user_sale = Permission::create(['name' => 'sale']);
        $user_delete = Permission::create(['name' => 'delete']);

         // Create user role.
         $admin_role = Role::create(['name' => 'admin']);
         $admin_role->givePermissionTo([
             $user_list,
             $user_view,
             $user_create,
             $user_update,
             $user_sale,
             $user_delete
         ]);

         $user_role = Role::create((['name' => 'user']));
         $user_role->givePermissionTo([
            $user_list,
            $user_view,
         ]);

        //Create customer role
        $customer_role = Role::create(['name' => 'customer']);

        //Create employee role
        $employee_role = Role::create(['name' => 'employee']);

        // Create Admin User.
        $admin = User::create([
            'username' => 'Admin',
            'firstname' => 'Max',
            'lastname' => 'Musterman',
            'role' => 'admin',
            'email' => 'admin@gmail.com',
            'status' => 1,
            'birthday' => '1997/02/08',
            'place_of_birth' => 'Lomé',
            'gender' => 'M',
            'password' => bcrypt('P@ssw0rd123'),
            'email_verified_at' => now()
        ]);

        $admin->assignRole($admin_role);
        $admin->givePermissionTo([
            $user_list,
            $user_view,
            $user_create,
            $user_update,
            $user_sale,
            $user_delete
        ]);

    }
}
