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
use app\common\service\MenuService;
use app\common\service\RoleService;
use Respect\Validation\Validator as v;
use support\Request;

class Role extends BaseController
{
    use CrudController;

    /**
     * @Inject
     *
     * @var RoleService
     */
    protected $service;

    /**
     * @Inject
     *
     * @var MenuService
     */
    protected $menu;

    public function validateRule()
    {
        return [
            'create' => [
                'title'    => v::notEmpty(),
                'actions'  => v::notEmpty(),
            ],
            'update' => [
                'title'    => v::notEmpty(),
                'actions'  => v::notEmpty(),
            ],
        ];
    }

    public function info(Request $request, $id)
    {
        $info = $this->service->info($id);

        return $this->sendSuccess(
            [
                'info'    => $info,
                'actions' => $info->actions->column('menu_action_id'),
            ]
        );
    }

    public function config()
    {
        return $this->sendSuccess(
            $this->menu->getRoleRuleTree()
        );
    }
}
