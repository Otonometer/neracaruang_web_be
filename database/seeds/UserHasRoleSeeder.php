<?php

use \App\Models\Role;
use \App\User;
use Illuminate\Database\Seeder;

class UserHasRoleSeeder extends Seeder
{
    public function run()
    {
        $role = Role::where('name','administrator')->first();
        $user = User::find(1);
        $rolePermissions = [];

        if($user){
            if($role){
                $user->syncRoles([0 => $role->id]);    
            }
        }
    }
}
