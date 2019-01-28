<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class LoginCheck
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
        $UUID = $request->header('UUID');
        if(!empty($UUID) && Redis::exists($UUID) == 0 && Redis::get($UUID) == null){
            return responseToJson(1,"您尚未登录");
        }
        return $next($request);
    }
}
