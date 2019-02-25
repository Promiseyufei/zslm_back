<?php

namespace App\Http\Middleware;

use Closure;

use Response;

class Cors
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

        // echo 111;
        // var_dump($request->ajax());
        // $request->header('Access-Control-Allow-Origin', env('RequestHttp', 'localhost:8080'));
        // $request->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Cookie, Accept');
        // $request->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, OPTIONS');
        // $request->header('Access-Control-Allow-Credentials', 'true');

        // $response = $next($request);
        // $response->header('Access-Control-Allow-Origin', '*');
        // $response->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Cookie, Accept, multipart/form-data, application/json,x-www-form-urlencoded, UUID, Authorization, X-Requested-With, Application');
        // $response->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, OPTIONS');
        // $response->header('Access-Control-Allow-Credentials', 'true');
        // return $response;


        $response = $next($request);
        $IlluminateResponse = 'Illuminate\Http\Response';
        $SymfonyResopnse = 'Symfony\Component\HttpFoundation\Response';
        $headers = [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, PATCH, DELETE',
            'Access-Control-Allow-Headers' => 'Origin, Content-Type, Cookie, Accept, multipart/form-data, application/json,x-www-form-urlencoded, UUID, Authorization, X-Requested-With, Application'
        ];
        
        if ($response instanceof $IlluminateResponse) {
            foreach ($headers as $key => $value) {
                $response->header($key, $value);
            }
            return $response;
        }
        
        if ($response instanceof $SymfonyResopnse) {
            foreach ($headers as $key => $value) {
                $response->headers->set($key, $value);
            }
            return $response;
        }
        
        return $response;
    }
}
