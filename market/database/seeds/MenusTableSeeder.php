<?php

use Illuminate\Database\Seeder;
use App\Menu;

class MenusTableSeeder extends Seeder
{
        public function run()
    {
        Menu::firstOrCreate([
            'name' => [
                "en"=>"Main",
                "ru"=>"Главный",
                "am"=>"Գլխավոր"
            ],
        ]);
        Menu::firstOrCreate([
            'name' => [
                "en"=>"Footer",
                "ru"=>"Нижний Колонтитул",
                "am"=>"Էջատակ"
            ],
        ]);
        Menu::firstOrCreate([
            'name' => [
                "en"=>"Quick Links",
                "ru"=>"Быстрые ссылки",
                "am"=>"Արագ հղումներ"
            ],
        ]);
    }
}
