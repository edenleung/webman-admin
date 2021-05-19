<?php

namespace support\bootstrap\db;

use Webman\Bootstrap;
use think\facade\Db;

class Thinkphp implements Bootstrap
{
    // 进程启动时调用
    public static function start($worker)
    {
        Db::setConfig(config('thinkorm'));
    }
}
