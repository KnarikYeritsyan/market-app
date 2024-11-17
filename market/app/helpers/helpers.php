<?php
use App\Setting;

if (! function_exists('setting')) {
    function setting($key, $default = null) {
        return Setting::where('key',$key)->first()->value ?: $default;
    }
}

if (! function_exists('setting_fall_lang')) {
    function setting_fall_lang($key, $default = null) {
        $value = Setting::where('key',$key)->first();
        return $value->getTranslation('value', 'en') ?: $default;
    }
}

if (! function_exists('setting_set')) {
    function setting_set($key, $value) {
        return Setting::where('key',$key)->update([
            'value' => [
                'en' => $value,
                'ru' => $value,
                'am' => $value,
                ]
        ]);
    }
}

if (! function_exists('setting_set_array')) {
    function setting_set_array($key, $value = []) {
        return Setting::where('key',$key)->update([
            'value' => [
                'ru' => $value['ru'],
                'en' => $value['en'],
                'am' => $value['am'],
            ],
        ]);
    }
}

if (! function_exists('remove_query_params')) {
    function remove_query_params(array $params = [])
    {
        $url = url()->current();
        $query = request()->query();
        foreach ($params as $param) {
            unset($query[$param]);
        }
        return $query ? $url . '?' . http_build_query($query) : $url;
    }
}

if (! function_exists('add_query_params')) {
    function add_query_params(array $params = [])
    {
        $query = array_merge(
            request()->query(),
            $params
        );
        return url()->current() . '?' . http_build_query($query);
    }
}

if (! function_exists('append_url_params')) {
    function append_url_params(array $params = [])
    {
        $query = request()->query();
        foreach ($params as $param) {
            unset($query[$param]);
        }
        $query = array_merge(
            $query,
            $params
        );
        return url()->current() . '?' . http_build_query($query);
    }
}