<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class IndexController extends Controller
{
    function homePage()
    {
//        return view('welcome');
        return redirect()->route('guest.admin_signin',app()->getLocale());
    }

    public function admin_signin(){
        return view ('auth.admin.login');
    }

    public function lang($locale)
    {
        App::setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    }

    function getcategories()
    {
        $categories = Category::all();
        return response()->json(compact('categories'));
    }
}
