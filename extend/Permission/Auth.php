<?php

namespace Permission;

use Casbin\Enforcer;
use Casbin\Model\Model;

/**
 * class Auth
 * @package app
 */
class Auth
{
    /**
     * @var Enforcer
     */
    protected $enforcer;

    public function __construct()
    {
        $config = config('auth');
        $default = config('auth.default');
        $config = config('auth.enforcers.' . $default);
        $adapter = $config['adapter'];

        $configType = $config['model']['config_type'];

        $model = new Model();
        if ('file' == $configType) {
            $model->loadModel($config['model']['config_file_path']);
        } elseif ('text' == $configType) {
            $model->loadModel($config['model']['config_text']);
        }

        $adapter = \support\bootstrap\Container::make($adapter);
        $this->enforcer = new Enforcer($model, $adapter, config('auth.log.enabled', false));
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->enforcer, $name], $arguments);
    }
}
