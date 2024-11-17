<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (){
    $userLang = preg_split('/,|;/', request()->server('HTTP_ACCEPT_LANGUAGE'));
    foreach(config('app.available_locales') as $key=>$value){
        if(in_array($key, $userLang)) {
            app()->setLocale($key);
        }
    }
    return redirect(app()->getLocale().'/siteadmin');
})->name('guest');
//    Route::get('/lang/{locale}', 'IndexController@lang')->name('guest.lang');
//Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'setlocale','prefix' => '{locale}','where'=>['locale'=>'[a-zA-Z]{2}']],function () {

    Route::get('/', 'IndexController@homePage')->name('guest');
    Route::get('/siteadmin', 'IndexController@admin_signin')->name('guest.admin_signin');

    Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');

    Route::group(['namespace' => 'admin', 'prefix' => '/admin', 'middleware' => 'auth.admin'], function () {
        Route::get('/home', 'AdminController@index')->name('admin.home');
        Route::get('/profile', 'AdminController@profile')->name('admin.profile');
        Route::post('/profile', 'CrudAdminController@profile')->name('admin.profile');
        Route::post('/password', 'CrudAdminController@password')->name('admin.password');
//        contact message
        Route::get('/new-messages', 'AdminController@new_messages')->name('admin.new-messages');
        Route::get('/messages', 'AdminController@messages')->name('admin.messages');
        Route::get('/message-seen/{id}', 'CrudAdminController@message_seen')->name('admin.message-seen');
        Route::get('/message-delete/{id}', 'CrudAdminController@message_delete')->name('admin.message-delete');
        Route::get('/clear-messages', 'CrudAdminController@clear_messages')->name('admin.clear-messages');
//        categories
        Route::get('/categories', 'AdminController@categories')->name('admin.categories');
        Route::get('/category/{id}', 'AdminController@show_category')->name('admin.category');
        Route::post('/category/{id}', 'CrudAdminController@edit_category')->name('admin.category');
        Route::get('/category-create', 'AdminController@category_create')->name('admin.category-create');
        Route::post('/category-create', 'CrudAdminController@category_create_post')->name('admin.category-create');
        Route::get('/category-delete/{id}', 'CrudAdminController@category_delete')->name('admin.category-delete');
//        brands
        Route::get('/brands', 'AdminController@brands')->name('admin.brands');
        Route::get('/brand/{id}', 'AdminController@show_brand')->name('admin.brand');
        Route::post('/brand/{id}', 'CrudAdminController@edit_brand')->name('admin.brand');
        Route::get('/brand-create', 'AdminController@brand_create')->name('admin.brand-create');
        Route::post('/brand-create', 'CrudAdminController@brand_create_post')->name('admin.brand-create');
        Route::get('/brand-delete/{id}', 'CrudAdminController@brand_delete')->name('admin.brand-delete');
//        products
        Route::get('/products', 'AdminController@products')->name('admin.products');
        Route::get('/product/{id}', 'AdminController@show_product')->name('admin.product');
        Route::post('/product/{id}', 'CrudAdminController@edit_product')->name('admin.product');
        Route::post('/product-images-add/{id}', 'CrudAdminController@product_images_add')->name('admin.product-images-add');
        Route::post('/product-images-sort/{id}', 'CrudAdminController@product_images_sort')->name('admin.product-images-sort');
        Route::get('/product-create', 'AdminController@product_create')->name('admin.product-create');
        Route::post('/product-create', 'CrudAdminController@product_create_post')->name('admin.product-create');
        Route::get('/product-delete/{id}', 'CrudAdminController@product_delete')->name('admin.product-delete');
        Route::post('/product-delete-image', 'CrudAdminController@product_delete_image')->name('admin.product-delete-image');
//        tags
        Route::get('/tags', 'AdminController@tags')->name('admin.tags');
        Route::get('/tag/{id}', 'AdminController@show_tag')->name('admin.tag');
        Route::post('/tag/{id}', 'CrudAdminController@edit_tag')->name('admin.tag');
        Route::get('/tag-create', 'AdminController@tag_create')->name('admin.tag-create');
        Route::post('/tag-create', 'CrudAdminController@tag_create_post')->name('admin.tag-create');
        Route::get('/tag-delete/{id}', 'CrudAdminController@tag_delete')->name('admin.tag-delete');
//        pages
        Route::get('/pages', 'AdminController@pages')->name('admin.pages');
        Route::get('/page/{id}', 'AdminController@show_page')->name('admin.page');
        Route::post('/page/{id}', 'CrudAdminController@edit_page')->name('admin.page');
        Route::get('/page-create', 'AdminController@page_create')->name('admin.page-create');
        Route::post('/page-create', 'CrudAdminController@page_create_post')->name('admin.page-create');
        Route::get('/page-delete/{id}', 'CrudAdminController@page_delete')->name('admin.page-delete');
//        posts
        Route::get('/posts', 'AdminController@posts')->name('admin.posts');
        Route::get('/post/{id}', 'AdminController@show_post')->name('admin.post');
        Route::post('/post/{id}', 'CrudAdminController@edit_post')->name('admin.post');
        Route::get('/post-create', 'AdminController@post_create')->name('admin.post-create');
        Route::post('/post-create', 'CrudAdminController@post_create_post')->name('admin.post-create');
        Route::get('/post-delete/{id}', 'CrudAdminController@post_delete')->name('admin.post-delete');
//        sliders
        Route::get('/sliders', 'AdminController@sliders')->name('admin.sliders');
        Route::get('/slider/{id}', 'AdminController@show_slider')->name('admin.slider');
        Route::post('/slider/{id}', 'CrudAdminController@edit_slider')->name('admin.slider');
        Route::get('/slider-create', 'AdminController@slider_create')->name('admin.slider-create');
        Route::post('/slider-create', 'CrudAdminController@slider_create_post')->name('admin.slider-create');
        Route::get('/slider-delete/{id}', 'CrudAdminController@slider_delete')->name('admin.slider-delete');
//        social media
        Route::get('/social-media', 'AdminController@social_media')->name('admin.social-media');
        Route::get('/media-delete/{id}', 'CrudAdminController@media_delete')->name('admin.media-delete');
        Route::post('/media-update', 'CrudAdminController@media_update')->name('admin.media-update');
        Route::post('/media-create', 'CrudAdminController@media_create')->name('admin.media-create');
//      menu
        Route::get('/menus', 'AdminController@menus')->name('admin.menus');
        Route::get('/menu-builder/{id}', 'AdminController@menu_builder')->name('admin.menu-builder');
        Route::post('/add-menu', 'CrudAdminController@add_menu')->name('admin.add-menu');
        Route::post('/menu-delete', 'CrudAdminController@menu_delete')->name('admin.menu-delete');
        Route::post('/menu-sort', 'CrudAdminController@menu_sort')->name('admin.menu-sort');
        Route::post('/menu-save', 'CrudAdminController@menu_save')->name('admin.menu-save');
//        settings
        Route::get('/setting', 'AdminController@site_settings')->name('admin.setting');
        Route::post('/setting', 'CrudAdminController@settings_update')->name('admin.setting');
        Route::get('/setting-contact', 'AdminController@site_settings_contact')->name('admin.setting-contact');
        Route::post('/setting-contact', 'CrudAdminController@settings_contact_update')->name('admin.setting-contact');

        Route::post('/admin-form', 'AdminController@admin_form')->name('admin-form');
        Route::post('/admin-logout', 'AdminController@admin_logout')->name('admin-logout');
    });

    Route::group(['namespace' => 'user', 'prefix' => '/user', 'middleware' => 'auth'], function () {
        Route::get('/home', 'UserController@index')->name('user.home');
        Route::get('/product', 'UserController@product')->name('user.product');
        Route::post('/user-logout', 'UserController@user_logout')->name('user-logout');
    });

});