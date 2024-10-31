<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Administrator',
                'email'          => 'admin@redtech.co.id',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'image'          => 'https://via.placeholder.com/500',
                'password'       => bcrypt('redtech.co.id'),
                'remember_token' => bcrypt('redtech.co.id'),
                'created_at'     =>  date('Y-m-d H:i:s'),
                'updated_at'     => null,
                'deleted_at'     => null,
            ]
        ];

        User::insert($users);
    }
}
