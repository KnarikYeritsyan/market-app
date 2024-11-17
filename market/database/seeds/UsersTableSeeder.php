<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'role' => 'admin',
            'status' => '1',
            'name' => 'admin',
            'phone' => '09999999999',
            'email' => 'admin.adminyan@gmail.com',
            'password' => bcrypt('11111111'),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('users')->insert([
            'role' => 'user',
            'status' => '1',
            'name' => 'user',
            'phone' => '09999999999',
            'email' => 'user.useryan@gmail.com',
            'password' => bcrypt('11111111'),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
    }
}
