<?php

namespace support\bootstrap;

use webman\Bootstrap;

/**
 * 服务容器注册
 */
class Service implements Bootstrap
{
    public static function start($worker)
    {
        $services = config('service', []);

        foreach($services as $service){
            \support\bootstrap\Container::make($service);
        }
    }
}
