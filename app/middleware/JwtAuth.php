<?php

namespace app\middleware;

use app\common\model\User;
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

        $token = jwt()->getVerifyToken();
        $identifier = $token->claims()->get('jti');
        $request->user = User::find($identifier);
        $response = $next($request);
        return $response;
    }
}
