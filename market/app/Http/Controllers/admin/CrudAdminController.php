<?php

namespace App\Http\Controllers\admin;

use App\Brand;
use App\Category;
use App\ContactMessage;
use App\Http\Controllers\Controller;
use App\MenuItem;
use App\Page;
use App\Post;
use App\Product;
use App\ProductImage;
use App\ProductType;
use App\Setting;
use App\Slider;
use App\SocialItem;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;

class CrudAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            return $next($request);
        });

    }

    public function profile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|string|unique:users,email,'.Auth::user()->id,
        ]);
        Auth::user()->name = $request['name'];
        Auth::user()->email = $request['email'];
        Auth::user()->save();
        return redirect()->back()->with('message', __('Profile updated successfully'));
    }

    public function password(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);
        if (!Hash::check($request['current_password'], auth()->user()->password)){
            return redirect()->back()->withErrors('Current password does not match');
        }
        Auth::user()->password = Hash::make($request['password']);
        Auth::user()->save();
        return redirect()->back()->with('message', __('Password changed successfully'));
    }

    function message_seen(Request $request)
    {
        ContactMessage::find($request->id)->update([
            'clicked' => 1
        ]);
        return redirect()->back()->with('message',__('Updated successfully'));
    }

    function message_delete(Request $request)
    {
        ContactMessage::find($request->id)->delete();
        return redirect()->back()->with('message',__('Deleted successfully'));
    }

    function clear_messages()
    {
        ContactMessage::truncate();
        return redirect()->back()->with('message',__('Cleared successfully'));
    }

    function edit_category(Request $request)
    {
        $request->validate([
            'slug' => 'required|unique:categories,slug,'.$request->upd_id,
            'status' => 'required|in:0,1',
            'name_ru' => 'required',
            'name_en' => 'required',
            'description_ru' => 'required',
            'description_en' => 'required',
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $filename = time() . '.' . $image->getClientOriginalExtension();

            $image_resize = Image::make($image->getRealPath());
            $w = $image_resize->width();
            $h = $image_resize->height();
            if ($w > $h) {
                $image_resize->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            } else {
                $image_resize->resize(null, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
//            $image_resize->resizeCanvas(300, 300);
            $dest_path = public_path('/assets/img/categories');
            $image->move($dest_path . '/img/', $filename);
            $image_resize->save($dest_path . '/img_resize/' . $filename);

            $category = Category::find($request->upd_id);
            if ($category) {
                if ($category->image_name !== '' && file_exists(public_path($category->image_name))) {
                    unlink(public_path($category->image_name));
                    unlink(public_path($category->image_name_resize));
                }
                $category->image_name = '/assets/img/categories/img/' . $filename;
                $category->image_name_resize = '/assets/img/categories/img_resize/' . $filename;
                $category->save();
            }
        }
            Category::where('id',$request->upd_id)->update([
            'name' => [
                'ru' => $request['name_ru'],
                'en' => $request['name_en'],
                'am' => $request['name_am'],
            ],
            'description' => [
                'ru' => $request['description_ru'],
                'en' => $request['description_en'],
                'am' => $request['description_am'],
            ],
            'slug'=>$request['slug'],
            'status'=>$request['status'],
        ]);

        return redirect()->back()->with('message', __('Category updated successfully'));
    }

    function category_create_post(Request $request)
    {
        $request->validate([
            'slug' => 'required|unique:categories,slug',
            'status' => 'required|in:0,1',
            'name_ru' => 'required',
            'name_en' => 'required',
            'description_ru' => 'required',
            'description_en' => 'required',
        ]);
        if ($request->hasFile('image')){
            $image = $request->file('image');

            $filename = time() . '.' . $image->getClientOriginalExtension();

            $image_resize = Image::make($image->getRealPath());
            $w = $image_resize->width();
            $h = $image_resize->height();
            /*if($w > $h) {
                $image_resize->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            } else {
                $image_resize->resize(null, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }*/
            $image_resize->resizeCanvas(300, 300);
            $dest_path = public_path('/assets/img/categories');
        }
        $category = Category::create([
            'name' => [
                'ru' => $request['name_ru'],
                'en' => $request['name_en'],
                'am' => $request['name_am'],
            ],
            'description' => [
                'ru' => $request['description_ru'],
                'en' => $request['description_en'],
                'am' => $request['description_am'],
            ],
            'image_name'=>'',
            'image_name_resize'=>'',
            'slug'=>$request['slug'],
            'status'=>$request['status'],
        ]);
        if ($request->hasFile('image')) {
            $category->image_name = '/assets/img/categories/img/' . $filename;
            $category->image_name_resize = '/assets/img/categories/img_resize/' . $filename;
            $category->save();
            $image->move($dest_path . "/img/", $filename);
            $image_resize->save($dest_path . "/img_resize/" . $filename);
        }
        return redirect()->route('admin.category',['locale'=>app()->getLocale(),'id'=>$category->id])->with('message', __('Category created successfully'));
    }

    function category_delete(Request $request)
    {
        $category = Category::find($request->id);
        if($category->image_name !== '' && file_exists(public_path($category->image_name))){
            unlink(public_path($category->image_name));
            unlink(public_path($category->image_name_resize));
        }
        Category::destroy($request->id);
        return redirect()->back()->with('message', __('Category deleted successfully'));
    }

    function brand_create_post(Request $request)
    {
        $request->validate([
            'slug' => 'required|unique:brands,slug',
            'name' => 'required',
            'status' => 'required|in:0,1',
            'description_ru' => 'required',
            'description_en' => 'required',
            'excerpt_ru' => 'required',
            'excerpt_en' => 'required',
        ]);
        if ($request->hasFile('image')){
            $image = $request->file('image');

            $filename = time() . '.' . $image->getClientOriginalExtension();

            $image_resize = Image::make($image->getRealPath());
            $w = $image_resize->width();
            $h = $image_resize->height();
            /*if($w > $h) {
                $image_resize->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            } else {
                $image_resize->resize(null, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }*/
            $image_resize->resizeCanvas(300, 300);
            $dest_path = public_path('/assets/img/brands');
        }
        $brand = Brand::create([
            'name' => $request['name'],
            'description' => [
                'ru' => $request['description_ru'],
                'en' => $request['description_en'],
                'am' => $request['description_am'],
            ],
            'excerpt' => [
                'ru' => $request['excerpt_ru'],
                'en' => $request['excerpt_en'],
                'am' => $request['excerpt_am'],
            ],
            'image_name'=>'',
            'image_name_resize'=>'',
            'slug'=>$request['slug'],
            'status'=>$request['status'],
        ]);
        if ($request->hasFile('image')) {
            $brand->image_name = '/assets/img/brands/img/' . $filename;
            $brand->image_name_resize = '/assets/img/brands/img_resize/' . $filename;
            $brand->save();
            $image->move($dest_path . "/img/", $filename);
            $image_resize->save($dest_path . "/img_resize/" . $filename);
        }
        return redirect()->route('admin.brand',['locale'=>app()->getLocale(),'id'=>$brand->id])->with('message', __('Brand created successfully'));
    }

    function edit_brand(Request $request)
    {
        $request->validate([
            'slug' => 'required|unique:brands,slug,'.$request->upd_id,
            'name' => 'required',
            'status' => 'required|in:0,1',
            'description_ru' => 'required',
            'description_en' => 'required',
            'excerpt_ru' => 'required',
            'excerpt_en' => 'required',
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $filename = time() . '.' . $image->getClientOriginalExtension();

            $image_resize = Image::make($image->getRealPath());
            $w = $image_resize->width();
            $h = $image_resize->height();
            /*if ($w > $h) {
                $image_resize->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            } else {
                $image_resize->resize(null, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }*/
            $image_resize->resizeCanvas(300, 300);
            $dest_path = public_path('/assets/img/brands');
            $image->move($dest_path . "/img/", $filename);
            $image_resize->save($dest_path . "/img_resize/" . $filename);

            $brand = Brand::find($request->upd_id);
            if ($brand) {
                if ($brand->image_name !== '' && file_exists(public_path($brand->image_name))) {
                    unlink(public_path($brand->image_name));
                    unlink(public_path($brand->image_name_resize));
                }
                $brand->image_name = '/assets/img/brands/img/' . $filename;
                $brand->image_name_resize = '/assets/img/brands/img_resize/' . $filename;
                $brand->save();
            }
        }
        Brand::where('id',$request->upd_id)->update([
            'name' => $request['name'],
            'slug'=>$request['slug'],
            'status'=>$request['status'],
            'description' => [
                'ru' => $request['description_ru'],
                'en' => $request['description_en'],
                'am' => $request['description_am'],
            ],
            'excerpt' => [
                'ru' => $request['excerpt_ru'],
                'en' => $request['excerpt_en'],
                'am' => $request['excerpt_am'],
            ],
        ]);

        return redirect()->back()->with('message', __('Brand updated successfully'));
    }

    function brand_delete(Request $request)
    {
        $brand = Brand::find($request->id);
        if($brand->image_name !== '' && file_exists(public_path($brand->image_name))){
            unlink(public_path($brand->image_name));
            unlink(public_path($brand->image_name_resize));
        }
        Brand::destroy($request->id);
        return redirect()->back()->with('message', __('Brand deleted successfully'));
    }

    function tag_create_post(Request $request)
    {
        $request->validate([
            'slug' => 'required|unique:tags,slug',
            'name_ru' => 'required',
            'name_en' => 'required',
            'color' => 'required',
            'status' => 'required|in:0,1',
        ]);
        $tag = Tag::create([
            'name' => [
                'ru' => $request['name_ru'],
                'en' => $request['name_en'],
                'am' => $request['name_am'],
            ],
            'slug'=>$request['slug'],
            'color'=>$request['color'],
            'status'=>$request['status'],
        ]);
        return redirect()->route('admin.tag',['locale'=>app()->getLocale(),'id'=>$tag->id])->with('message', __('Tag created successfully'));
    }

    function edit_tag(Request $request)
    {
        $request->validate([
            'slug' => 'required|unique:tags,slug,'.$request->upd_id,
            'name_ru' => 'required',
            'name_en' => 'required',
            'color' => 'required',
            'status' => 'required|in:0,1',
        ]);
        Tag::where('id',$request->upd_id)->update([
            'name' => [
                'ru' => $request['name_ru'],
                'en' => $request['name_en'],
                'am' => $request['name_am'],
            ],
            'slug'=>$request['slug'],
            'color'=>$request['color'],
            'status'=>$request['status'],
        ]);

        return redirect()->back()->with('message', __('Tag updated successfully'));
    }

    function tag_delete(Request $request)
    {
        $tag = Tag::find($request->id);
        Tag::destroy($request->id);
        return redirect()->back()->with('message', __('Tag deleted successfully'));
    }

    function product_create_post(Request $request)
    {
        $request->validate([
            'slug' => 'required|unique:products,slug',
            'name_ru' => 'required',
            'name_en' => 'required',
            'description_ru' => 'required',
            'description_en' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'sale' => 'numeric|max:100',
            'status' => 'required|in:0,1',
            'volume' => 'required|numeric',
            'image' => 'mimes:jpg,jpeg,png,bmp,gif',
            'images.*' => 'mimes:jpg,jpeg,png,bmp,gif',
            'prices.*' => 'numeric',
            'quantities.*' => 'numeric',
        ]);
        if ($request->hasFile('image')){
            $image = $request->file('image');

            $filename = time(). $image->getClientOriginalName();

            $image_resize = Image::make($image->getRealPath());
            $w = $image_resize->width();
            $h = $image_resize->height();
            if($w > $h) {
                $image_resize->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            } else {
                $image_resize->resize(null, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
            $dest_path = public_path('/assets/img/products');
        }
        $product = Product::create([
            'name' => [
                'ru' => $request['name_ru'],
                'en' => $request['name_en'],
                'am' => $request['name_am'],
            ],
            'description' => [
                'ru' => $request['description_ru'],
                'en' => $request['description_en'],
                'am' => $request['description_am'],
            ],
            'image_name'=>'',
            'image_name_resize'=>'',
            'slug'=>$request['slug'],
            'price'=>isset($request['price'])?$request['price']:0,
            'quantity'=>isset($request['quantity'])?$request['quantity']:1,
            'sale'=>isset($request['sale'])?$request['sale']:0,
            'aroma'=>$request['aroma'],
            'type'=>$request['type'],
            'volume'=>isset($request['volume'])?$request['volume']:0,
            'category_id'=>$request['category_id'],
            'brand_id'=>isset($request['brand_id'])?$request['brand_id']:null,
            'tag_id'=>isset($request['tag_id'])?$request['tag_id']:null,
            'status'=>$request['status'],
        ]);
        $product->related_products()->attach($request['products']);
        if (!empty($request['volumes'])) {
            foreach ($request['volumes'] as $key=>$volume) {
                ProductType::create([
                    'product_id' => $product->id,
                    'type' => $volume,
                    'price' => $request['prices'][$key],
                    'quantity' => $request['quantities'][$key],
                ]);
            }
        }
        if ($request->hasFile('image')) {
            $product->image_name = '/assets/img/products/img/' . $filename;
            $product->image_name_resize = '/assets/img/products/img_resize/' . $filename;
            $product->save();
            $image->move($dest_path . "/img/", $filename);
            $image_resize->save($dest_path . "/img_resize/" . $filename);
        }
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $image = $file;
                $filename = time(). $image->getClientOriginalName();
                $image_resize = Image::make($image->getRealPath());
                $w = $image_resize->width();
                $h = $image_resize->height();
                if ($w > $h) {
                    $image_resize->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } else {
                    $image_resize->resize(null, 300, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                $dest_path = public_path('/assets/img/products');
                $image->move($dest_path . "/img/", $filename);
                $image_resize->save($dest_path . "/img_resize/" . $filename);
                $count = Product::find($product->id)->images->count();
                $productimg = ProductImage::create([
                    'product_id'=>$product->id,
                    'sort_order'=>$count+1,
                    'image_name'=>'/assets/img/products/img/' . $filename,
                    'image_name_resize'=>'/assets/img/products/img_resize/' . $filename,
                ]);
            }
        }
        return redirect()->route('admin.product',['locale'=>app()->getLocale(),'id'=>$product->id])->with('message', __('Product created successfully'));
    }

    function edit_product(Request $request)
    {
        $request->validate([
            'slug' => 'required|unique:products,slug,'.$request->upd_id,
            'name_ru' => 'required',
            'name_en' => 'required',
            'description_ru' => 'required',
            'description_en' => 'required',
            'price' => 'required|numeric',
            'sale' => 'numeric|max:100',
            'volume' => 'required|numeric',
            'quantity' => 'required|numeric',
            'status' => 'required|in:0,1',
            'prices.*' => 'numeric',
            'quantities.*' => 'numeric',
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $filename = time(). $image->getClientOriginalName();

            $image_resize = Image::make($image->getRealPath());
            $w = $image_resize->width();
            $h = $image_resize->height();
            if ($w > $h) {
                $image_resize->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            } else {
                $image_resize->resize(null, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
            $dest_path = public_path('/assets/img/products');
            $image->move($dest_path . "/img/", $filename);
            $image_resize->save($dest_path . "/img_resize/" . $filename);

            $product = Product::find($request->upd_id);
            if ($product) {
                if ($product->image_name !== '' && file_exists(public_path($product->image_name))) {
                    unlink(public_path($product->image_name));
                    unlink(public_path($product->image_name_resize));
                }
                $product->image_name = '/assets/img/products/img/' . $filename;
                $product->image_name_resize = '/assets/img/products/img_resize/' . $filename;
                $product->save();
            }
        }
        $product = Product::where('id',$request->upd_id)->first();
        $product->related_products()->sync($request['products']);
        if (!empty($product->options)) {
            foreach ($product->options as $option) {
                if (!in_array($option->type, $request['volumes'])) {
                    $option->delete();
                }
            }
        }
        if (!empty($request['volumes'])) {
            foreach ($request['volumes'] as $key=>$volume) {
                $type = ProductType::firstOrCreate([
                    'product_id' => $product->id, 'type' => $volume
                ]);
                $type->price = $request['prices'][$key];
                $type->quantity = $request['quantities'][$key];
                $type->save();
            }
        }
        $product->update([
            'name' => [
                'ru' => $request['name_ru'],
                'en' => $request['name_en'],
                'am' => $request['name_am'],
            ],
            'description' => [
                'ru' => $request['description_ru'],
                'en' => $request['description_en'],
                'am' => $request['description_am'],
            ],
            'slug'=>$request['slug'],
            'price'=>isset($request['price'])?$request['price']:0,
            'quantity'=>isset($request['quantity'])?$request['quantity']:1,
            'sale'=>isset($request['sale'])?$request['sale']:0,
            'aroma'=>$request['aroma'],
            'type'=>$request['type'],
            'volume'=>isset($request['volume'])?$request['volume']:0,
            'category_id'=>$request['category_id'],
            'brand_id'=>isset($request['brand_id'])?$request['brand_id']:null,
            'tag_id'=>isset($request['tag_id'])?$request['tag_id']:null,
            'status'=>$request['status'],
        ]);

        return redirect()->back()->with('message', __('Product updated successfully'));
    }

    function product_images_add(Request $request)
    {
        $input_data = $request->all();
        $validator = Validator::make(
            $input_data, [
            'files.*' => 'required|mimes:jpg,jpeg,png,bmp,gif|max:20000'
        ],[
                'files.*.required' => __('Please upload an image'),
                'files.*.mimes' => __('Only png,jpg,jpeg and gif images are allowed'),
                'files.*.max' => __('Sorry! Maximum allowed size for an image is 20MB'),
            ]
        );
        if ($validator->fails()) {
            return response(['error' => $validator->getMessageBag()->toArray()], 400);
        }
        if ($request->hasFile('files')) {
            $data = [];
            foreach ($request->file('files') as $file) {
                $image = $file;
                $filename = time(). $image->getClientOriginalName();
                $image_resize = Image::make($image->getRealPath());
                $w = $image_resize->width();
                $h = $image_resize->height();
                if ($w > $h) {
                    $image_resize->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } else {
                    $image_resize->resize(null, 300, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                $dest_path = public_path('/assets/img/products');
                $image->move($dest_path . "/img/", $filename);
                $image_resize->save($dest_path . "/img_resize/" . $filename);
                $count = Product::find($request->id)->images->count();
                $productimg = ProductImage::create([
                    'product_id'=>$request->id,
                    'sort_order'=>$count+1,
                    'image_name'=>'/assets/img/products/img/' . $filename,
                    'image_name_resize'=>'/assets/img/products/img_resize/' . $filename,
                ]);
                $data[$productimg->id] = '/assets/img/products/img_resize/' . $filename;
            }
            return response(['success' => true,'data'=>$data], 201);
        }
    }

    function product_images_sort(Request $request)
    {
        $sorts = $request['ids'];
        foreach ($sorts as $sort=>$value)
        {
            $image = ProductImage::find($value);
            $image->sort_order = $sort+1;
            $image->save();
        }
        return response(['success' => true], 201);
    }

    function product_delete_image(Request $request)
    {
        $sorts = $request['ids'];
        ProductImage::destroy($request['image_id']);
        foreach ($sorts as $sort=>$value)
        {
            $image = ProductImage::find($value);
            $image->sort_order = $sort+1;
            $image->save();
        }
        return response(['success' => true], 201);
    }

    function product_delete(Request $request)
    {
        $product = Product::find($request->id);
        $productimg = $product->images;
        foreach ($productimg as $img){
            unlink(public_path($img->image_name));
            unlink(public_path($img->image_name_resize));
            $img->delete();
        }
        if($product->image_name !== '' && file_exists(public_path($product->image_name))){
            unlink(public_path($product->image_name));
            unlink(public_path($product->image_name_resize));
        }
        Product::destroy($request->id);
        return redirect()->back()->with('message', __('Product deleted successfully'));
    }

    function media_create(Request $request)
    {
        $request->validate([
            'title' => 'string',
            'link' => 'required|url',
            'type' => 'required',
            'status' => 'required|in:0,1',
        ]);
        SocialItem::create([
            'title'=>$request['title'],
            'link'=>$request['link'],
            'type'=>$request['type'],
            'status'=>$request['status'],
        ]);
        return redirect()->back()->with('message', __('Media created successfully'));
    }

    function media_update(Request $request)
    {
        $request->validate([
            'title' => 'string',
            'link' => 'required|url',
            'type' => 'required',
            'status' => 'required|in:0,1',
        ]);
        SocialItem::where('id',$request['upd_id'])->update([
            'title'=>$request['title'],
            'link'=>$request['link'],
            'type'=>$request['type'],
            'status'=>$request['status'],
        ]);
        return redirect()->back()->with('message', __('Media updated successfully'));
    }

    function media_delete(Request $request)
    {
        SocialItem::destroy($request->id);
        return redirect()->back()->with('message', __('Media deleted successfully'));
    }

    function page_create_post(Request $request)
    {
        $request->validate([
            'slug' => 'required|unique:pages,slug',
            'title_ru' => 'required',
            'title_en' => 'required',
            'status' => 'required|in:0,1',
            'content_ru' => 'required',
            'content_en' => 'required',
        ]);
        if ($request->hasFile('image')){
            $image = $request->file('image');

            $filename = time() . $image->getClientOriginalName();

            $image_resize = Image::make($image->getRealPath());
            $w = $image_resize->width();
            $h = $image_resize->height();
            if($w > $h) {
                $image_resize->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            } else {
                $image_resize->resize(null, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
            $dest_path = public_path('/assets/img/pages');
        }
        $page = Page::create([
            'content' => [
                'ru' => $request['content_ru'],
                'en' => $request['content_en'],
                'am' => $request['content_am'],
            ],
            'title' => [
                'ru' => $request['title_ru'],
                'en' => $request['title_en'],
                'am' => $request['title_am'],
            ],
            'meta_description' => [
                'ru' => $request['meta_description_ru'],
                'en' => $request['meta_description_en'],
                'am' => $request['meta_description_am'],
            ],
            'meta_keywords' => [
                'ru' => $request['meta_keywords_ru'],
                'en' => $request['meta_keywords_en'],
                'am' => $request['meta_keywords_am'],
            ],
            'image_name'=>'',
            'image_name_resize'=>'',
            'slug'=>$request['slug'],
            'status'=>$request['status'],
        ]);
        if ($request->hasFile('image')) {
            $page->image_name = '/assets/img/pages/img/' . $filename;
            $page->image_name_resize = '/assets/img/pages/img_resize/' . $filename;
            $page->save();
            $image->move($dest_path . "/img/", $filename);
            $image_resize->save($dest_path . "/img_resize/" . $filename);
        }
        return redirect()->route('admin.page',['locale'=>app()->getLocale(),'id'=>$page->id])->with('message', __('Page created successfully'));
    }

    function edit_page(Request $request)
    {
        $request->validate([
            'slug' => 'required|unique:pages,slug,'.$request->upd_id,
            'status' => 'required|in:0,1',
            'title_ru' => 'required',
            'title_en' => 'required',
            'content_ru' => 'required',
            'content_en' => 'required',
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $filename = time() . $image->getClientOriginalName();

            $image_resize = Image::make($image->getRealPath());
            $w = $image_resize->width();
            $h = $image_resize->height();
            if ($w > $h) {
                $image_resize->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            } else {
                $image_resize->resize(null, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
            $dest_path = public_path('/assets/img/pages');
            $image->move($dest_path . "/img/", $filename);
            $image_resize->save($dest_path . "/img_resize/" . $filename);

            $page = Page::find($request->upd_id);
            if ($page) {
                if ($page->image_name !== '' && file_exists(public_path($page->image_name))) {
                    unlink(public_path($page->image_name));
                    unlink(public_path($page->image_name_resize));
                }
                $page->image_name = '/assets/img/pages/img/' . $filename;
                $page->image_name_resize = '/assets/img/pages/img_resize/' . $filename;
                $page->save();
            }
        }
        Page::where('id',$request->upd_id)->update([
            'title' => [
                'ru' => $request['title_ru'],
                'en' => $request['title_en'],
                'am' => $request['title_am'],
            ],
            'content' => [
                'ru' => $request['content_ru'],
                'en' => $request['content_en'],
                'am' => $request['content_am'],
            ],
            'meta_description' => [
                'ru' => $request['meta_description_ru'],
                'en' => $request['meta_description_en'],
                'am' => $request['meta_description_am'],
            ],
            'meta_keywords' => [
                'ru' => $request['meta_keywords_ru'],
                'en' => $request['meta_keywords_en'],
                'am' => $request['meta_keywords_am'],
            ],
            'slug'=>$request['slug'],
            'status'=>$request['status'],
        ]);

        return redirect()->back()->with('message', __('Page updated successfully'));
    }

    function page_delete(Request $request)
    {
        $page = Page::find($request->id);
        if($page->image_name !== '' && file_exists(public_path($page->image_name))){
            unlink(public_path($page->image_name));
            unlink(public_path($page->image_name_resize));
        }
        Page::destroy($request->id);
        return redirect()->back()->with('message', __('Page deleted successfully'));
    }

    function post_create_post(Request $request)
    {
        $request->validate([
            'slug' => 'required|unique:posts,slug',
            'title_ru' => 'required',
            'title_en' => 'required',
            'status' => 'required|in:0,1',
            'content_ru' => 'required',
            'content_en' => 'required',
        ]);
        if ($request->hasFile('image')){
            $image = $request->file('image');

            $filename = time() . $image->getClientOriginalName();

            $image_resize = Image::make($image->getRealPath());
            $w = $image_resize->width();
            $h = $image_resize->height();
            if($w > $h) {
                $image_resize->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            } else {
                $image_resize->resize(null, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
            $dest_path = public_path('/assets/img/posts');
        }
        $post = Post::create([
            'content' => [
                'ru' => $request['content_ru'],
                'en' => $request['content_en'],
                'am' => $request['content_am'],
            ],
            'title' => [
                'ru' => $request['title_ru'],
                'en' => $request['title_en'],
                'am' => $request['title_am'],
            ],
            'meta_description' => [
                'ru' => $request['meta_description_ru'],
                'en' => $request['meta_description_en'],
                'am' => $request['meta_description_am'],
            ],
            'meta_keywords' => [
                'ru' => $request['meta_keywords_ru'],
                'en' => $request['meta_keywords_en'],
                'am' => $request['meta_keywords_am'],
            ],
            'image_name'=>'',
            'image_name_resize'=>'',
            'slug'=>$request['slug'],
            'status'=>$request['status'],
            'author_id'=>Auth::user()->id,
        ]);
        if ($request->hasFile('image')) {
            $post->image_name = '/assets/img/posts/img/' . $filename;
            $post->image_name_resize = '/assets/img/posts/img_resize/' . $filename;
            $post->save();
            $image->move($dest_path . "/img/", $filename);
            $image_resize->save($dest_path . "/img_resize/" . $filename);
        }
        return redirect()->route('admin.post',['locale'=>app()->getLocale(),'id'=>$post->id])->with('message', __('Post created successfully'));
    }

    function edit_post(Request $request)
    {
        $request->validate([
            'slug' => 'required|unique:posts,slug,'.$request->upd_id,
            'status' => 'required|in:0,1',
            'title_ru' => 'required',
            'title_en' => 'required',
            'content_ru' => 'required',
            'content_en' => 'required',
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $filename = time() . $image->getClientOriginalName();

            $image_resize = Image::make($image->getRealPath());
            $w = $image_resize->width();
            $h = $image_resize->height();
            if ($w > $h) {
                $image_resize->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            } else {
                $image_resize->resize(null, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
            $dest_path = public_path('/assets/img/posts');
            $image->move($dest_path . "/img/", $filename);
            $image_resize->save($dest_path . "/img_resize/" . $filename);

            $post = Post::find($request->upd_id);
            if ($post) {
                if ($post->image_name !== '' && file_exists(public_path($post->image_name))) {
                    unlink(public_path($post->image_name));
                    unlink(public_path($post->image_name_resize));
                }
                $post->image_name = '/assets/img/posts/img/' . $filename;
                $post->image_name_resize = '/assets/img/posts/img_resize/' . $filename;
                $post->save();
            }
        }
        Post::where('id',$request->upd_id)->update([
            'title' => [
                'ru' => $request['title_ru'],
                'en' => $request['title_en'],
                'am' => $request['title_am'],
            ],
            'content' => [
                'ru' => $request['content_ru'],
                'en' => $request['content_en'],
                'am' => $request['content_am'],
            ],
            'meta_description' => [
                'ru' => $request['meta_description_ru'],
                'en' => $request['meta_description_en'],
                'am' => $request['meta_description_am'],
            ],
            'meta_keywords' => [
                'ru' => $request['meta_keywords_ru'],
                'en' => $request['meta_keywords_en'],
                'am' => $request['meta_keywords_am'],
            ],
            'slug'=>$request['slug'],
            'status'=>$request['status'],
        ]);

        return redirect()->back()->with('message', __('Post updated successfully'));
    }

    function post_delete(Request $request)
    {
        $post = Post::find($request->id);
        if($post->image_name !== '' && file_exists(public_path($post->image_name))){
            unlink(public_path($post->image_name));
            unlink(public_path($post->image_name_resize));
        }
        Post::destroy($request->id);
        return redirect()->back()->with('message', __('Post deleted successfully'));
    }

    function slider_create_post(Request $request)
    {
        $request->validate([
            'slug' => 'required|unique:sliders,slug',
            'title_ru' => 'required',
            'title_en' => 'required',
            'status' => 'required|in:0,1',
            'description_ru' => 'required',
            'description_en' => 'required',
        ]);
        if ($request->hasFile('image')){
            $image = $request->file('image');

            $filename = time() . $image->getClientOriginalName();

            $image_resize = Image::make($image->getRealPath());
            $w = $image_resize->width();
            $h = $image_resize->height();
            if($w > $h) {
                $image_resize->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            } else {
                $image_resize->resize(null, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
            $dest_path = public_path('/assets/img/sliders');
        }
        $slider = Slider::create([
            'description' => [
                'ru' => $request['description_ru'],
                'en' => $request['description_en'],
                'am' => $request['description_am'],
            ],
            'title' => [
                'ru' => $request['title_ru'],
                'en' => $request['title_en'],
                'am' => $request['title_am'],
            ],
            'image_name'=>'',
            'image_name_resize'=>'',
            'slug'=>$request['slug'],
            'status'=>$request['status'],
        ]);
        if ($request->hasFile('image')) {
            $slider->image_name = '/assets/img/sliders/img/' . $filename;
            $slider->image_name_resize = '/assets/img/sliders/img_resize/' . $filename;
            $slider->save();
            $image->move($dest_path . "/img/", $filename);
            $image_resize->save($dest_path . "/img_resize/" . $filename);
        }
        return redirect()->route('admin.slider',['locale'=>app()->getLocale(),'id'=>$slider->id])->with('message', __('Slider created successfully'));
    }

    function edit_slider(Request $request)
    {
        $request->validate([
            'slug' => 'required|unique:sliders,slug,'.$request->upd_id,
            'status' => 'required|in:0,1',
            'title_ru' => 'required',
            'title_en' => 'required',
            'description_ru' => 'required',
            'description_en' => 'required',
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $filename = time() . $image->getClientOriginalName();

            $image_resize = Image::make($image->getRealPath());
            $w = $image_resize->width();
            $h = $image_resize->height();
            if ($w > $h) {
                $image_resize->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            } else {
                $image_resize->resize(null, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
            $dest_path = public_path('/assets/img/sliders');
            $image->move($dest_path . "/img/", $filename);
            $image_resize->save($dest_path . "/img_resize/" . $filename);

            $slider = Slider::find($request->upd_id);
            if ($slider) {
                if ($slider->image_name !== '' && file_exists(public_path($slider->image_name))) {
                    unlink(public_path($slider->image_name));
                    unlink(public_path($slider->image_name_resize));
                }
                $slider->image_name = '/assets/img/sliders/img/' . $filename;
                $slider->image_name_resize = '/assets/img/sliders/img_resize/' . $filename;
                $slider->save();
            }
        }
        Slider::where('id',$request->upd_id)->update([
            'title' => [
                'ru' => $request['title_ru'],
                'en' => $request['title_en'],
                'am' => $request['title_am'],
            ],
            'description' => [
                'ru' => $request['description_ru'],
                'en' => $request['description_en'],
                'am' => $request['description_am'],
            ],
            'slug'=>$request['slug'],
            'status'=>$request['status'],
        ]);

        return redirect()->back()->with('message', __('Slider updated successfully'));
    }

    function slider_delete(Request $request)
    {
        $slider = Slider::find($request->id);
        if($slider->image_name !== '' && file_exists(public_path($slider->image_name))){
            unlink(public_path($slider->image_name));
            unlink(public_path($slider->image_name_resize));
        }
        Slider::destroy($request->id);
        return redirect()->back()->with('message', __('Slider deleted successfully'));
    }

    function settings_update(Request $request)
    {
        $request->validate([
            'logo' => 'mimes:jpg,jpeg,png,bmp,gif|max:20000',
            'favicon' => 'mimes:jpg,jpeg,png,bmp,gif|max:20000',
            'title_ru' => 'required',
            'title_en' => 'required',
            'description_ru' => 'required',
            'description_en' => 'required',
        ]);
        if ($request->hasFile('logo')){
            $image = $request->file('logo');

            $filename = time() . $image->getClientOriginalName();

            $image_resize = Image::make($image->getRealPath());
            $w = $image_resize->width();
            $h = $image_resize->height();
            if($w > $h) {
                $image_resize->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            } else {
                $image_resize->resize(null, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
            $dest_path = public_path('/assets/img/settings/');
            $image->move($dest_path , $filename);
//            $image_resize->save($dest_path . $filename);
            $old = setting_fall_lang('site.logo');
            if ($old){
                unlink(public_path($old));
            }
            setting_set('site.logo','/assets/img/settings/'.$filename);
        }
        if ($request->hasFile('favicon')){
            $image = $request->file('favicon');
            $filename = time() . $image->getClientOriginalName();
            $dest_path = public_path('/assets/img/settings/');
            $image->move($dest_path , $filename);
            $old = setting_fall_lang('site.favicon');
            if ($old){
                unlink(public_path($old));
            }
            setting_set('site.favicon','/assets/img/settings/'.$filename);
        }
        setting_set('site.google_analytics_tracking_id',$request['google_analytics_tracking_id']);
        setting_set_array('site.title',[
            'ru' => $request['title_ru'],
            'en' => $request['title_en'],
            'am' => $request['title_am'],
        ]);
        setting_set_array('site.description',[
            'ru' => $request['description_ru'],
            'en' => $request['description_en'],
            'am' => $request['description_am'],
        ]);
        return redirect()->back()->with('message', __('Settings updated successfully'));
    }

    function settings_contact_update(Request $request)
    {
        $request->validate([
            'email' => 'email',
//            'phone_ru' => 'required',
//            'phone_en' => 'required',
//            'address_ru' => 'string',
//            'address_en' => 'string',
//            'open_hours_ru' => 'required',
//            'open_hours_en' => 'required',
        ]);
        setting_set('contact.email',$request['email']);
        setting_set_array('contact.phone',[
            'ru' => $request['phone_ru'],
            'en' => $request['phone_en'],
            'am' => $request['phone_am'],
        ]);
        setting_set_array('contact.address',[
            'ru' => $request['address_ru'],
            'en' => $request['address_en'],
            'am' => $request['address_am'],
        ]);
        setting_set_array('contact.open_hours',[
            'ru' => $request['open_hours_ru'],
            'en' => $request['open_hours_en'],
            'am' => $request['open_hours_am'],
        ]);
        return redirect()->back()->with('message', __('Contact Settings updated successfully'));
    }

    function add_menu(Request $request)
    {
        $request->validate([
            'menu-group' => 'required|in:page,shop,brand,tag,custom_link,categories',
        ]);
        if ($request['menu-group'] == 'page') {
            $request->validate([
                'conn_ids' => 'required',
            ]);
            $data = [];
            foreach ($request['conn_ids'] as $conn_id) {
                $page = Page::find($conn_id);
                $count = MenuItem::where('menu_id', $request->menu_id)->whereNull('parent_id')->count();
                $item = MenuItem::create([
                    'menu_id' => $request->menu_id,
                    'conn_id' => $conn_id,
                    'group' => 'page',
                    'sort_order' => $count + 1,
                    'title' => [
                        'ru' => isset($page->translations['title']['ru']) ? $page->translations['title']['ru'] : '',
                        'en' => isset($page->translations['title']['en']) ? $page->translations['title']['en'] : '',
                        'am' => isset($page->translations['title']['am']) ? $page->translations['title']['am'] : '',
                    ],
                ]);
                $item->show_title = $item->title;
                $item->show_group = __($item->group);
                if ($item->wasRecentlyCreated) {
                    $data[] = $item;
                }
            }
            return response(['success' => true, 'data' => $data], 201);
        }
        if ($request['menu-group'] == 'categories') {
            $request->validate([
                'conn_ids' => 'required',
            ]);
            $data = [];
            foreach ($request['conn_ids'] as $conn_id) {
                $count = MenuItem::where('menu_id', $request->menu_id)->whereNull('parent_id')->count();
                if ($conn_id != 'null') {
                    $category = Category::find($conn_id);
                    $item = MenuItem::create([
                        'menu_id' => $request->menu_id,
                        'conn_id' => $conn_id,
                        'group' => 'categories',
                        'type' => 'category',
                        'sort_order' => $count + 1,
                        'title' => [
                            'ru' => isset($category->translations['name']['ru']) ? $category->translations['name']['ru'] : '',
                            'en' => isset($category->translations['name']['en']) ? $category->translations['name']['en'] : '',
                            'am' => isset($category->translations['name']['am']) ? $category->translations['name']['am'] : '',
                        ],
                    ]);
                    $item->show_title = $item->title;
                    $item->show_group = __($item->type);
                    if ($item->wasRecentlyCreated) {
                        $data[] = $item;
                    }
                } else {
                    $item = MenuItem::create([
                        'menu_id' => $request->menu_id,
                        'group' => 'categories',
                        'sort_order' => $count + 1,
                        'title' => [
                            'ru' => 'Категории',
                            'en' => 'Categories',
                            'am' => 'Կատեգորիաներ',
                        ],
                    ]);
                    $item->show_title = $item->title;
                    $item->show_group = __($item->group);
                    if ($item->wasRecentlyCreated) {
                        $data[] = $item;
                    }
                }
            }
            return response(['success' => true, 'data' => $data], 201);
        }
        if ($request['menu-group'] == 'shop') {
            $request->validate([
                'conn_ids' => 'required',
            ]);
            $data = [];
            foreach ($request['conn_ids'] as $conn_id) {
                $count = MenuItem::where('menu_id', $request->menu_id)->whereNull('parent_id')->count();
                    $item = MenuItem::create([
                        'menu_id' => $request->menu_id,
                        'group' => 'shop',
                        'sort_order' => $count + 1,
                        'title' => [
                            'ru' => 'Магазин',
                            'en' => 'Shop',
                            'am' => 'Խանութ',
                        ],
                    ]);
                    $item->show_title = $item->title;
                    $item->show_group = __($item->group);
                    if ($item->wasRecentlyCreated) {
                        $data[] = $item;
                    }
            }
            return response(['success' => true, 'data' => $data], 201);
        }

        if ($request['menu-group'] == 'brand') {
            $request->validate([
                'conn_ids' => 'required',
            ]);
            $data = [];
            foreach ($request['conn_ids'] as $conn_id) {
                $count = MenuItem::where('menu_id', $request->menu_id)->whereNull('parent_id')->count();
                if ($conn_id != 'null') {
                    $brand = Brand::find($conn_id);
                    $item = MenuItem::create([
                        'menu_id' => $request->menu_id,
                        'conn_id' => $conn_id,
                        'group' => 'brand',
                        'type' => 'brand',
                        'sort_order' => $count + 1,
                        'title' => [
                            'ru' => $brand->name,
                            'en' => $brand->name,
                            'am' => $brand->name,
                        ],
                    ]);
                    $item->show_title = $item->title;
                    $item->show_group = __($item->group);
                    if ($item->wasRecentlyCreated) {
                        $data[] = $item;
                    }
                } else {
                    $item = MenuItem::create([
                        'menu_id' => $request->menu_id,
                        'group' => 'brand',
                        'sort_order' => $count + 1,
                        'title' => [
                            'ru' => 'Бренды',
                            'en' => 'Brands',
                            'am' => 'Ապրանքանիշեր',
                        ],
                    ]);
                    $item->show_title = $item->title;
                    $item->show_group = __($item->group);
                    if ($item->wasRecentlyCreated) {
                        $data[] = $item;
                    }
                }
            }
            return response(['success' => true, 'data' => $data], 201);
        }
        if ($request['menu-group'] == 'tag') {
            $request->validate([
                'conn_ids' => 'required',
            ]);
            $data = [];
            foreach ($request['conn_ids'] as $conn_id) {
                $count = MenuItem::where('menu_id', $request->menu_id)->whereNull('parent_id')->count();
                if ($conn_id != 'null') {
                    $tag = Tag::find($conn_id);
                    $item = MenuItem::create([
                        'menu_id' => $request->menu_id,
                        'conn_id' => $conn_id,
                        'group' => 'tag',
                        'type' => 'tag',
                        'sort_order' => $count + 1,
                        'title' => [
                            'ru' => isset($tag->translations['name']['ru']) ? $tag->translations['name']['ru'] : '',
                            'en' => isset($tag->translations['name']['en']) ? $tag->translations['name']['en'] : '',
                            'am' => isset($tag->translations['name']['am']) ? $tag->translations['name']['am'] : '',
                        ],
                    ]);
                    $item->show_title = $item->title;
                    $item->show_group = __($item->group);
                    if ($item->wasRecentlyCreated) {
                        $data[] = $item;
                    }
                } else {
                    $item = MenuItem::create([
                        'menu_id' => $request->menu_id,
                        'group' => 'tag',
                        'sort_order' => $count + 1,
                        'title' => [
                            'ru' => 'Теги',
                            'en' => 'Tags',
                            'am' => 'Պիտակներ',
                        ],
                    ]);
                    $item->show_title = $item->title;
                    $item->show_group = __($item->group);
                    if ($item->wasRecentlyCreated) {
                        $data[] = $item;
                    }
                }
            }
            return response(['success' => true, 'data' => $data], 201);
        }
        if ($request['menu-group'] == 'custom_link') {
            $request->validate([
                'url' => 'required|url',
                'url_text' => 'required',
            ]);
            $data = [];
            $count = MenuItem::where('menu_id', $request->menu_id)->whereNull('parent_id')->count();
            $item = MenuItem::create([
                'menu_id' => $request->menu_id,
                'group' => 'custom_link',
                'url' => $request['url'],
                'sort_order' => $count + 1,
                'target' => '_blank',
                'title' => [
                    'ru' => $request['url_text'],
                    'en' => $request['url_text'],
                    'am' => $request['url_text'],
                ],
            ]);
            $item->show_title = $item->title;
            $item->show_group = __($item->group);
            if ($item->wasRecentlyCreated) {
                $data[] = $item;
            }
        return response(['success' => true, 'data' => $data], 201);
    }

    }

    function menu_save(Request $request)
    {
        $menu = MenuItem::find($request['item_id']);
        $menu->update([
            'title' => [
                'ru' => $request['title_ru'],
                'en' => $request['title_en'],
                'am' => $request['title_am'],
            ],
            'url' => isset($request['url'])?$request['url']:null
        ]);
        if($request->ajax()){
            return response(['success' => true], 201);
        }else{
            return redirect()->back()->with('message', __('Done!'));
        }
    }

    function menu_delete(Request $request)
    {
        $sorts = json_decode($request['ids']);
        $menu = MenuItem::find($request['item_id']);
        $menu->delete();
        $this->buildSort($sorts);
        return response(['success' => true], 201);
    }

    function menu_sort(Request $request)
    {
        $sorts = json_decode($request['ids']);
        $this->buildSort($sorts);
        return response(['success' => true], 201);
    }

    function buildSort($elements, $parentId = null) {
        foreach ($elements as $key=>$element) {
            $item = MenuItem::find($element->id);
            $item->update([
                'sort_order'=> $key+1,
                'parent_id'=> $parentId,
            ]);
            if (isset($element->children)){
                $this->buildSort($element->children,$element->id);
            }
        }
    }
}
