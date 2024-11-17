<?php

use Illuminate\Database\Seeder;
use App\Setting;

class SettingsTableSeeder extends Seeder
{
    public function run()
    {
        $setting = $this->findSetting('site.title');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => [
                    "en"=>"Title",
                    "ru"=>"Заглавие",
                    "am"=>"Վերնագիր"
                ],
                'value'        => [
                    "en"=>"My Market",
                    "ru"=>"Мой рынок",
                    "am"=>""
                ],
                'type'         => 'text',
                'name'         => 'title',
                'group'        => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.description');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => [
                    "en"=>"Description",
                    "ru"=>"Описание",
                    "am"=>"Նկարագրություն"
                ],
                'value'         => [
                    "en"=>"Description",
                    "ru"=>"Мой рынок",
                    "am"=>""
                ],
                'type'         => 'text',
                'name'         => 'description',
                'group'        => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.logo');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => [
                    "en"=>"Logo",
                    "ru"=>"Логотип",
                    "am"=>"Լոգո"
                ],
                'value'        => '',
                'type'         => 'file',
                'name'         => 'logo',
                'group'        => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.favicon');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => [
                    "en"=>"Favicon",
                    "ru"=>"Значок сайта",
                    "am"=>"Favicon"
                ],
                'value'        => '',
                'type'         => 'file',
                'name'         => 'favicon',
                'group'        => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.google_analytics_tracking_id');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => [
                    "en"=>"Google analytics tracking id",
                    "ru"=>"Идентификатор отслеживания Google Analytics",
                    "am"=>"Google-ի վերլուծության հետևող ID"
                ],
                'value'        => '',
                'type'         => 'text',
                'name'         => 'google_analytics_tracking_id',
                'group'        => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('contact.email');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => [
                    "en"=>"Email",
                    "ru"=>"Эл. адрес",
                    "am"=>"Էլ․ փոստ"
                ],
                'value'        => '',
                'type'         => 'text',
                'name'         => 'email',
                'group'        => 'Contact',
            ])->save();
        }

        $setting = $this->findSetting('contact.phone');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => [
                    "en"=>"Phone",
                    "ru"=>"Телефон",
                    "am"=>"Հեռախոսահամար"
                ],
                'value'        => '',
                'type'         => 'text',
                'name'         => 'phone',
                'group'        => 'Contact',
            ])->save();
        }

        $setting = $this->findSetting('contact.address');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => [
                    "en"=>"Address",
                    "ru"=>"Адрес",
                    "am"=>"Հասցե"
                ],
                'value'        => '',
                'type'         => 'text',
                'name'         => 'address',
                'group'        => 'Contact',
            ])->save();
        }

        $setting = $this->findSetting('contact.open_hours');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => [
                    "en"=>"Open hours",
                    "ru"=>"Открытые часы",
                    "am"=>"Բաց ժամեր"
                ],
                'value'        => '',
                'type'         => 'text',
                'name'         => 'open_hours',
                'group'        => 'Contact',
            ])->save();
        }
    }

    /**
     * [setting description].
     *
     * @param [type] $key [description]
     *
     * @return [type] [description]
     */
    protected function findSetting($key)
    {
        return Setting::firstOrNew(['key' => $key]);
    }
}
