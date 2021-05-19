<?php

declare(strict_types=1);

/*
 * This file is part of TAnt.
 * @link     https://github.com/edenleung/think-admin
 * @document https://www.kancloud.cn/manual/thinkphp6_0
 * @contact  QQ Group 996887666
 * @author   Eden Leung 758861884@qq.com
 * @copyright 2019 Eden Leung
 * @license  https://github.com/edenleung/think-admin/blob/6.0/LICENSE.txt
 */

namespace app\admin\controller\system;

use app\BaseController;
use Crud\CrudController;
use think\annotation\Inject;
use Auth\User\AuthorizationController;
use app\common\service\MenuActionService;
use Respect\Validation\Validator as v;

class Action extends BaseController
{
    use CrudController;

    public function validateRule()
    {
        return [
            'create' => [
                'permission'    => v::notEmpty(),
                'title'         => v::notEmpty(),
                'pid'           => v::notEmpty(),
            ],
            'update' => [
                'permission'    => v::notEmpty(),
                'title'         => v::notEmpty(),
                'pid'           => v::notEmpty(),
            ],
        ];
    }

    /**
     * @Inject
     *
     * @var MenuActionService
     */
    protected $service;
}
