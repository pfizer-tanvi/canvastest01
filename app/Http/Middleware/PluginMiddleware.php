<?php

namespace App\Http\Middleware;

use App\Events\ResponseHook;
use Closure;
use Illuminate\Support\Arr;

class PluginMiddleware
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
        $response = $next($request);
        //json response only
        $data = $response->getData(true);

        $event = event(new ResponseHook($data));

        $response->setData(Arr::first($event));
        return $response;
    }
}
