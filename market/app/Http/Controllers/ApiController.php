<?php

namespace App\Http\Controllers;

use App\ContactMessage;
use App\Models\Brand;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Tag;
use App\SocialItem;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    function sliders()
    {
        $sliders = Slider::where('status','1')->get();
        return response()->json(compact('sliders'));
    }

    function send_contact_message(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|string',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create([
            'ip' => $request['term'],
            'name' => $request['name'],
            'email' => $request['email'],
            'subject' => $request['subject'],
            'message' => $request['message']
        ]);
        return response()->json(['success'=>true,'message'=>__('Message Sent!')]);
    }

    function settings()
    {
        $settings = Setting::select('key','value')->pluck('value','key');
        $menu = MenuItem::where('menu_id',1)->whereNull('parent_id')->orderBy('sort_order')->with('children')->get();
        $footer_menu = MenuItem::where('menu_id',2)->whereNull('parent_id')->orderBy('sort_order')->get();
        $footer_links = MenuItem::where('menu_id',3)->whereNull('parent_id')->orderBy('sort_order')->get();
        $social_items = SocialItem::where('status','1')->get();
        return response()->json(compact('settings','menu','footer_links','footer_menu','social_items'));
    }

    function get_page(Request $request)
    {
        $page = Page::where('slug',$request->slug)->first();
        return response()->json(compact('page'));
    }

    function get_product(Request $request)
    {
        $product = Product::where('slug',$request->slug)->with('images','tag:id,name','category:id,name,slug','related_products')->first();
        return response()->json(compact('product'));
    }

    function tag_products()
    {
        $tags = Tag::where('status','1')->with('products_4')->get();
        return response()->json(compact('tags'));
    }

    function get_tags()
    {
        $tags = Tag::where('status','1')->get();
        $products = Product::where('status',1)->with('tag')->paginate(5);
        return response()->json(compact('tags','products'));
    }

    function two_random_products()
    {
        $products = Product::where('status',1)->inRandomOrder()->limit(2)->get();
        return response()->json(compact('products'));
    }

    function get_tag(Request $request)
    {
        $tags = Tag::where('status','1')->get();
        $tag = Tag::where('slug',$request->slug)->where('status',1)->with('products')->first();
        return response()->json(compact('tag','tags'));
    }

    function get_brands(Request $request)
    {
        $brands = Brand::where('status',1)->get();
        return response()->json(compact('brands'));
    }

    function get_brand(Request $request)
    {
        $brands = Brand::where('status',1)->get();
        $brand = Brand::where('slug',$request->slug)->where('status',1)->with('products')->first();
        return response()->json(compact('brands','brand'));
    }

    function get_products(Request $request)
    {
        $products = Product::where('status',1)->with('tag');
        if (isset($request->sort_by)){
            $field = explode(':',$request->sort_by)[0];
            $sort = explode(':',$request->sort_by)[1];
            $products = $products->orderBy($field, $sort);
        }else{
            $products = $products->orderBy('created_at', 'desc');
        }
        if (isset($request->show_items)){
            $products = $products->paginate($request->show_items);
        }else{
            $products = $products->paginate(5);
        }
        $categories = Category::where('status',1)->withCount('products')->get();
        return response()->json(compact('products','categories'));
    }

    function search_products(Request $request)
    {
        $products = Product::where('status',1)->with('tag');

        if (isset($request->from_price)){
            $products->where('price', '>=',$request->from_price);
        }
        if (isset($request->to_price)){
            $products->where('price', '<=',$request->to_price);
        }
        if (isset($request->category)){
            $products->whereIn('category_id',$request->category);
        }
        if (isset($request->volume)){
            $products->whereIn('volume',$request->volume);
        }
        if (isset($request->type)){
            $products->whereIn('type',$request->type);
        }
        if (isset($request->aroma)){
            $products->whereIn('aroma',$request->aroma);
        }
        if (isset($request->sort_by)){
            $field = explode(':',$request->sort_by)[0];
            $sort = explode(':',$request->sort_by)[1];
            $products = $products->orderBy($field, $sort);
        }else{
            $products = $products->orderBy('created_at', 'desc');
        }
        if (isset($request->show_items)){
            $products = $products->paginate($request->show_items);
        }else{
            $products = $products->paginate(5);
        }
        $categories = Category::where('status',1)->withCount('products')->get();
        return response()->json(compact('products','categories'));
    }

    function find_products(Request $request)
    {
        $ids = explode(',',$request->ids);
        $products = Product::find($ids);
        return response()->json(compact('products'));
    }

    function search_product($slug,Request $request)
    {
        $products = Product::query()->where('status',1)->with('tag');

        if (isset($slug)){
            $products->where('name', 'like','%'.$slug.'%');
        }
        if (isset($request->from_price)){
            $products->where('price', '>=',$request->from_price);
        }
        if (isset($request->to_price)){
            $products->where('price', '<=',$request->to_price);
        }
        if (isset($request->category)){
            $products->whereIn('category_id',$request->category);
        }
        if (isset($request->volume)){
            $products->whereIn('volume',$request->volume);
        }
        if (isset($request->type)){
            $products->whereIn('type',$request->type);
        }
        if (isset($request->aroma)){
            $products->whereIn('aroma',$request->aroma);
        }
        if (isset($request->sort_by)){
            $field = explode(':',$request->sort_by)[0];
            $sort = explode(':',$request->sort_by)[1];
            $products = $products->orderBy($field, $sort);
        }else{
            $products = $products->orderBy('created_at', 'desc');
        }
        if (isset($request->show_items)){
            $products = $products->paginate($request->show_items);
        }else{
            $products = $products->paginate(5);
        }
        $categories = Category::where('status',1)->withCount('products')->get();
        return response()->json(compact('products','categories'));
    }

    function get_categories(Request $request)
    {
        $categories = Category::where('status',1)->get();
        return response()->json(compact('categories'));
    }

    function get_category(Request $request)
    {
        $category = Category::where('status',1)->where('slug',$request->slug)->withCount('products')->first();
        $products = Product::where('status',1)->where('category_id',$category->id)->with('tag');
        if (isset($request->sort_by)){
            $field = explode(':',$request->sort_by)[0];
            $sort = explode(':',$request->sort_by)[1];
            $products = $products->orderBy($field, $sort);
        }else{
            $products = $products->orderBy('created_at', 'desc');
        }
        if (isset($request->show_items)){
            $products = $products->paginate($request->show_items);
        }else{
            $products = $products->paginate(5);
        }
        return response()->json(compact('category','products'));
    }

    function getstat(Request $request)
    {
        $items = MenuItem::whereNull('parent_id')->with('children')->get();
//        $items = MenuItem::whereNull('parent_id')->with('children1')->get();
//        $items = MenuItem::all();
//        $it = $this->buildTree($items);
//        $it = Product::all();
//        return $it;
        return $items;
//        return $this->setData($items);
    }

    protected function setData($value)
    {
        array_walk_recursive($value, function (&$item, $key) {
            $item = null === $item ? '' : $item;
        });
        return $value;
    }


    function buildTree($elements, $parentId = null) {
        $branch = [];
        foreach ($elements as $element) {
            if ($element->parent_id == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }
}
