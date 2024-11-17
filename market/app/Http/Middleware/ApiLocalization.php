<?php

namespace App\Http\Middleware;

use Closure;

class ApiLocalization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = $request->header('Content-Language');
        if(!$locale){
          $locale = app()->getLocale();
        }
        foreach(config('app.available_locales') as $key=>$value){
            if($locale == $key) {
                app()->setLocale($key);
            }
        }
        return $next($request)->header('Content-Language', app()->getLocale());
    }
}
