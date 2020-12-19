<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Super Admin',
            'slug' => 'superadmin',
            'description' => 'Role for super admin',
            'guard_name' => 'web',
            'permissions' =>'{"admin.dashboard":true,"users.attach.role.index":true,"users.attach.role.store":true,"users.index":true,"users.create":true,"users.store":true,"users.show":true,"users.edit":true,"users.update":true,"users.destroy":true,"roles.attached.users":true,"roles.permissions":true,"roles.permissions.store":true,"roles.index":true,"roles.create":true,"roles.store":true,"roles.show":true,"roles.edit":true,"roles.update":true,"roles.destroy":true}',
            'created_by' =>1,
            'updated_by' =>1,
        ]);

        Role::create([
            'name' => 'User',
            'slug' => 'user',
            'description' => 'Role for users',
            'guard_name' => 'web',
            'permissions' =>'{"users.dashboard":true}',
            'created_by' =>1,
            'updated_by' =>1,
        ]);

        $user1 = User::find(1);

        $user1->roles()->attach(1);

        $user2 = User::find(2);

        $user2->roles()->attach(2);
    }
}
