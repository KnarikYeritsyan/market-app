<?php

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
         $this->call(UsersTableSeeder::class);
         $this->call(MenusTableSeeder::class);
         $this->call(SettingsTableSeeder::class);
//        factory('App\MenuItem', 15)->create();
    }
}
