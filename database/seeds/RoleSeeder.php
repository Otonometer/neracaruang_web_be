<?php

use \App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'name'    => 'administrator',
                'guard_name' => 'web',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        Role::insert($roles);
    }
}
