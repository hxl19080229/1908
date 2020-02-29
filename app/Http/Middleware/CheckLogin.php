<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
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
        //根据session值 判断用户是否登陆
        $user = session('userInfo');
        if(!$user){
            return redirect('/login');
        }
        return $next($request);
    }
}
