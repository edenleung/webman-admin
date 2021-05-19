<?php

namespace app\middleware;

use Webman\MiddlewareInterface;
use Webman\Http\Response;
use Webman\Http\Request;

class AccessControl implements MiddlewareInterface
{
    public function process(Request $request, callable $next): Response
    {
        var_dump($request->method(). '=>' . $request->path());
        if (strpos($request->path(), '/admin') === 0) {
            if ($request->method() == 'OPTIONS') {
                $response = $next($request);
            } else {
                $response = $next($request);
            }
            $response->withHeaders([
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => 'GET,POST,PUT,DELETE,OPTIONS',
                'Access-Control-Allow-Headers' => 'Content-Type,Authorization,X-Requested-With,Accept,Origin',
            ]);
        } else {
            $response = $next($request);
        }
        return $response;
    }
}
