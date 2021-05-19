<?php

/**
 * This file is part of webman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link      http://www.workerman.net/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

use app\Auth;
use JwtAuth\Config;
use JwtAuth\JwtAuth;

return [
    JwtAuth::class => function () {
        $config = new Config(config('jwt'));
        $auth = new JwtAuth($config);
        return $auth;
    },
    Auth::class => function () {
        return new Auth();
    }
];
