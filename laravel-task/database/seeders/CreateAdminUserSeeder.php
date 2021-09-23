<?php

namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
  
class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin-user', 
            'email' => 'admin@gmail.com',
            'roles' => 1,
            'password' => bcrypt('12345678')
        ]);

        $user = User::create([
            'name' => 'Normal-user', 
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678')
        ]);
    
        $role = Role::create(['name' => 'Admin']);
        $role = Role::create(['name' => 'User']);
     
        $permissions = Permission::pluck('id','id')->all();
   
        $role->syncPermissions($permissions);
     
        $user->assignRole([$role->id]);
    }
}

