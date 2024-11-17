<?php

namespace App\Http\Controllers\admin;

use App\Brand;
use App\Category;
use App\ContactMessage;
use App\Http\Controllers\Controller;
use App\Menu;
use App\MenuItem;
use App\Page;
use App\Post;
use App\Product;
use App\Setting;
use App\Slider;
use App\SocialItem;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use View;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            View::share(['contact_count'=>ContactMessage::where('seen',0)->count()]);
            return $next($request);
        });

    }
    function index()
    {
        $categories = Category::all();
//        $categories = Category::where('name->en', 'Perfumes')->get();
        return view('admin.home',compact('categories'));
    }

    function profile()
    {
        $user = Auth::user();
        return view('admin.profile',compact('user'));
    }

    function new_messages()
    {
        $messages = ContactMessage::where('clicked',0)->orderBy('created_at','desc')->paginate(15);
        ContactMessage::where('seen',0)->update(['seen'=>1]);
        return view('admin.contact.new-contact',compact('messages'));
    }

    function messages()
    {
        $messages = ContactMessage::orderBy('created_at','desc')->paginate(15);
        return view('admin.contact.contact',compact('messages'));
    }

    function admin_form(Request $request)
    {
        $request->validate([
            'email'=>'digits_between:1,8'
        ]);
        return redirect()->back();
    }

    function categories(Request $request)
    {
        $categories = Category::orderBy('created_at', 'desc');
        if (isset($request->search_term)){
            $categories->where('name','like','%'.$request->search_term.'%');
        }
        $categories = $categories->paginate(15);
        return view('admin.category.categories',compact('categories'));
    }

    function brands(Request $request)
    {
        $brands = Brand::orderBy('created_at', 'desc');
        if (isset($request->search_term)){
            $brands->where('name','like','%'.$request->search_term.'%');
        }
        $brands = $brands->paginate(15);
        return view('admin.brand.brands',compact('brands'));
    }

    function social_media()
    {
        $medias = SocialItem::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.social-items',compact('medias'));
    }

    function products(Request $request)
    {
        $products = Product::query();
        $categories = Category::all();
        if (isset($request->search_term)){
            $products->where('name','like','%'.$request->search_term.'%');
        }
        if (isset($request->category)){
            $products->where('category_id',$request->category);
        }
        if (isset($request->sort)){
            $field = explode(':',$request->sort)[0];
            $sort = explode(':',$request->sort)[1];
            $products = $products->orderBy($field, $sort);
        }else{
            $products = $products->orderBy('created_at', 'desc');
        }
        $products = $products->paginate(5);
        return view('admin.product.products',compact('products','categories'));
    }

    function tags(Request $request)
    {
        $tags = Tag::orderBy('created_at', 'desc');
        if (isset($request->search_term)){
            $tags->where('name','like','%'.$request->search_term.'%');
        }
        $tags = $tags->paginate(15);
        return view('admin.tag.tags',compact('tags'));
    }

    function show_category(Request $request)
    {
        $category = Category::find($request->id);
        return view('admin.category.category',compact('category'));
    }

    function show_brand(Request $request)
    {
        $brand = Brand::find($request->id);
        return view('admin.brand.brand',compact('brand'));
    }

    function show_tag(Request $request)
    {
        $tag = Tag::find($request->id);
        return view('admin.tag.tag',compact('tag'));
    }

    function show_product(Request $request)
    {
        $categories = Category::all();
        $brands = Brand::all();
        $tags = Tag::all();
        $product = Product::find($request->id);
        $products = Product::all();
        return view('admin.product.product',compact('product','categories','brands','tags','products'));
    }

    function category_create()
    {
        return view('admin.category.category-new');
    }

    function product_create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $tags = Tag::all();
        $products = Product::all();
        return view('admin.product.product-new',compact('categories','brands','tags','products'));
    }

    function brand_create()
    {
        return view('admin.brand.brand-new');
    }

    function tag_create()
    {
        return view('admin.tag.tag-new');
    }

    function pages(Request $request)
    {
        $pages = Page::orderBy('created_at', 'desc');
        if (isset($request->search_term)){
            $pages->where('title','like','%'.$request->search_term.'%');
        }
        $pages = $pages->paginate(15);
        return view('admin.page.pages',compact('pages'));
    }

    function page_create()
    {
        return view('admin.page.page-new');
    }

    function show_page(Request $request)
    {
        $page = Page::find($request->id);
        return view('admin.page.page',compact('page'));
    }

    function posts(Request $request)
    {
        $posts = Post::orderBy('created_at', 'desc');
        if (isset($request->search_term)){
            $posts->where('title','like','%'.$request->search_term.'%');
        }
        $posts = $posts->paginate(15);
        return view('admin.post.posts',compact('posts'));
    }

    function post_create()
    {
        return view('admin.post.post-new');
    }

    function show_post(Request $request)
    {
        $post = Post::find($request->id);
        return view('admin.post.post',compact('post'));
    }

    function sliders()
    {
        $sliders = Slider::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.slider.sliders',compact('sliders'));
    }

    function slider_create()
    {
        return view('admin.slider.slider-new');
    }

    function show_slider(Request $request)
    {
        $slider = Slider::find($request->id);
        return view('admin.slider.slider',compact('slider'));
    }

    function menus()
    {
        $menus = Menu::all();
        return view('admin.menu.menus',compact('menus'));
    }

    function menu_builder(Request $request)
    {
        $pages = Page::all()->where('status','1');
        $categories = Category::all()->where('status',1);
        $tags = Tag::all()->where('status',1);
        $brands = Brand::all()->where('status',1);
        $menu = Menu::find($request->id);
//        $items = MenuItem::where('menu_id',$request->id)->get();
        $items = MenuItem::where('menu_id',$request->id)->whereNull('parent_id')->orderBy('sort_order')->with('children')->get();
        return view('admin.menu.builder',compact('items','menu','pages','categories','tags','brands'));
    }

    function site_settings(Request $request)
    {
        $settings = Setting::where('group','Site')->get();
        return view('admin.setting.settings',compact('settings'));
    }

    function site_settings_contact(Request $request)
    {
        $settings = Setting::where('group','Contact')->get();
        return view('admin.setting.settings-contact',compact('settings'));
    }

    public function admin_logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/'.app()->getLocale().'/siteadmin');
    }
}
