<?php

declare(strict_types=1);

namespace app\admin\controller;

use app\BaseController;
use Webman\Http\Request;
use Respect\Validation\Validator as v;
use app\common\service\UserService;
use JwtAuth\JwtAuth;

class Auth extends BaseController
{
    /**
     * @Inject
     * @var UserService
     */
    protected $service;

    public function login(Request $request)
    {
        $data = $request->post();

        $this->validate($data, [
            'username' => v::notEmpty()->setName('用户名'),
            'password' => v::notEmpty()->setName('密码')
        ]);

        $user = $this->service->login($data['username'], $data['password']);
        $token = jwt()->token($user->id, []);

        $config = jwt()->getConfig();

        return $this->sendSuccess([
            'token'      => $token->toString(),
            'token_type' => $config->getType(),
            'expires_in' => $config->getExpires(),
            'refresh_in' => $config->getRefreshTTL(),
        ]);
    }
}
