<?php

use \App\Models\Role;
use \App\Models\Permission;
use Illuminate\Database\Seeder;

class RoleHasPermissionSeeder extends Seeder
{
    public function run()
    {
        $role = Role::where('name','administrator')->first();
        $permissions = Permission::all();
        $rolePermissions = [];

        if($role){
            if($permissions->count() > 0){
                foreach($permissions as $permission){
                    $rolePermissions[] = @$permission->id;
                }  
    
            }
            $role->syncPermissions($rolePermissions);
        }
    }
}
