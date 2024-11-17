<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => 'api_setlocale'],function () {
    Route::get('settings', 'ApiController@settings');
    Route::get('get-page', 'ApiController@get_page');
    Route::get('get-product', 'ApiController@get_product');
    Route::get('get-tags', 'ApiController@get_tags');
    Route::get('get-tag', 'ApiController@get_tag');
    Route::get('get-brands', 'ApiController@get_brands');
    Route::get('get-brand', 'ApiController@get_brand');
    Route::get('get-products', 'ApiController@get_products');
    Route::get('search-products', 'ApiController@search_products');
    Route::get('find-products', 'ApiController@find_products');
    Route::get('search-product/{slug}', 'ApiController@search_product');
    Route::get('get-categories', 'ApiController@get_categories');
    Route::get('get-category', 'ApiController@get_category');
    Route::get('two-random-products', 'ApiController@two_random_products');
    Route::post('send-contact-message', 'ApiController@send_contact_message');

    Route::get('sliders', 'ApiController@sliders');
    Route::get('getstat', 'ApiController@getstat');
    Route::get('tag-products', 'ApiController@tag_products');
    Route::get('getcategories', 'IndexController@getcategories');
Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('refresh', 'AuthController@refresh');
    Route::group(['middleware' => 'api_auth:api'], function(){
        Route::get('user', 'AuthController@user');
        Route::post('logout', 'AuthController@logout');
    });
});
});
