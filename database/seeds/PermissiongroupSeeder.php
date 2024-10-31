<?php

use App\Models\Permissiongroup;
use Illuminate\Database\Seeder;

class PermissiongroupSeeder extends Seeder
{
    public function run()
    {
        $groups = [
            [
                'id' => 1,
                'name'  => 'User Management',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'name'  => 'Website',
                'created_at' => date('Y-m-d H:i:s'),
            ]
        ];

        Permissiongroup::insert($groups);
    }
}