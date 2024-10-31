<?php

use Database\Seeders\PageTypeSeed;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            PermissiongroupSeeder::class,
            PermissionsSeeder::class,
            RoleSeeder::class,
            RoleHasPermissionSeeder::class,
            UserHasRoleSeeder::class,
            PageTypeSeed::class,
        ]);

    }
}
