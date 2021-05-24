<?php

namespace app\middleware;

use Webman\MiddlewareInterface;
use Webman\Http\Response;
use Webman\Http\Request;

class JwtAuth implements MiddlewareInterface
{
    public function process(Request $request, callable $next): Response
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return json(['message' => '未登录']);
        }

        if (!jwt()->verify($token)) {
            return json(['message' => 'token 效验失败']);
        }

        $request->user = jwt()->getUser();
        $response = $next($request);

        return $response;
    }
}
