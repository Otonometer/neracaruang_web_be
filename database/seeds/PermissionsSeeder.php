<?php

use App\Models\Permission;
use App\Models\Permissionlabel;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        $labels = [
            [
                'id' => 1,
                'name' => 'Permission Group',
                'permission_group_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'name' => 'Permission',
                'permission_group_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 3,
                'name' => 'Roles',
                'permission_group_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 4,
                'name' => 'Users',
                'permission_group_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $permissions = [
            [
                'name'      => 'permissiongroup-create',
                'guard_name' => 'web',
                'permissions_label_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'      => 'permissiongroup-show',
                'guard_name' => 'web',
                'permissions_label_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'      => 'permissiongroup-edit',
                'guard_name' => 'web',
                'permissions_label_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'      => 'permissiongroup-update',
                'guard_name' => 'web',
                'permissions_label_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'      => 'permissiongroup-delete',
                'guard_name' => 'web',
                'permissions_label_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'      => 'permissiongroup-store',
                'guard_name' => 'web',
                'permissions_label_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'      => 'permission-create',
                'guard_name' => 'web',
                'permissions_label_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'      => 'permission-show',
                'guard_name' => 'web',
                'permissions_label_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'      => 'permission-edit',
                'guard_name' => 'web',
                'permissions_label_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'      => 'permission-update',
                'guard_name' => 'web',
                'permissions_label_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'      => 'permission-delete',
                'guard_name' => 'web',
                'permissions_label_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'      => 'permission-store',
                'guard_name' => 'web',
                'permissions_label_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'      => 'role-create',
                'guard_name' => 'web',
                'permissions_label_id' => 3,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'      => 'role-show',
                'guard_name' => 'web',
                'permissions_label_id' => 3,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'      => 'role-edit',
                'guard_name' => 'web',
                'permissions_label_id' => 3,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'      => 'role-update',
                'guard_name' => 'web',
                'permissions_label_id' => 3,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'      => 'role-delete',
                'guard_name' => 'web',
                'permissions_label_id' => 3,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'      => 'role-store',
                'guard_name' => 'web',
                'permissions_label_id' => 3,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'      => 'user-create',
                'guard_name' => 'web',
                'permissions_label_id' => 4,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'      => 'user-show',
                'guard_name' => 'web',
                'permissions_label_id' => 4,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'      => 'user-edit',
                'guard_name' => 'web',
                'permissions_label_id' => 4,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'      => 'user-update',
                'guard_name' => 'web',
                'permissions_label_id' => 4,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'      => 'user-delete',
                'guard_name' => 'web',
                'permissions_label_id' => 4,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'      => 'user-store',
                'guard_name' => 'web',
                'permissions_label_id' => 4,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        Permissionlabel::insert($labels);
        Permission::insert($permissions);
    }
}
