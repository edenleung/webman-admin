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
use app\common\service\DeptService;
use app\common\service\RoleService;
use app\common\service\UserService;
use Respect\Validation\Validator as v;
use support\Request;

class User extends BaseController
{
    protected $validates = [];

    /**
     * @Inject
     *
     * @var UserService
     */
    protected $service;

    /**
     * @Inject
     *
     * @var DeptService
     */
    protected $dept;

    public function index(Request $request)
    {
        $params = $request->get();

        return $this->sendSuccess($this->service->list($params));
    }

    public function create(Request $request)
    {
        $data = $request->post();
        $this->validate($data, [
            'username' => v::notEmpty(),
            'nickname' => v::notEmpty(),
            'password' => v::notEmpty(),
            'roles'    => v::notEmpty(),
            'dept_id'  => v::notEmpty(),
        ]);

        $this->service->create($data);

        return $this->sendSuccess();
    }

    public function update(Request $request, $id)
    {
        $data = $request->post();
        $this->validate($data, [
            'nickname' => v::notEmpty(),
            'roles'    => v::notEmpty(),
            'dept_id'  => v::notEmpty(),
        ]);

        $this->service->update($id, $data);

        return $this->sendSuccess();
    }

    public function delete(Request $request, $id)
    {
        $this->service->delete($id);

        return $this->sendSuccess();
    }

    public function info(Request $request)
    {
        $info = $this->service->info($request->user);

        return $this->sendSuccess($info);
    }

    public function menus(Request $request)
    {
        $info = $this->service->menus($request->user);

        return $this->sendSuccess($info);
    }

    public function permission(Request $request)
    {
        $info = $this->service->permission($request->user);

        return $this->sendSuccess($info);
    }

    public function view($id)
    {
        $info = $this->service->view($id);

        return $this->sendSuccess($info);
    }

    public function data(RoleService $role, DeptService $dept)
    {
        return $this->sendSuccess(
            [
                'roles' => $role->all(),
                'depts' => $dept->getTree(),
            ]
        );
    }

    public function current()
    {
        return $this->sendSuccess(request()->user);
    }

    public function updateCurrent()
    {
        $data = $this->request->post();
        if (empty($data)) {
            return $this->sendError('数据出错');
        }

        if (!$this->service->updateCurrent($this->user, $data)) {
            return $this->sendError('更新失败');
        }

        return $this->sendSuccess(null, '已更新个人信息');
    }

    /**
     * 更新头像.
     *
     * @return \think\Response
     */
    public function avatar(Request $request)
    {
        $file = $request->file('file');
        $savename = \think\facade\Filesystem::disk('public')->putFile('topic', $file);
        if (!$this->service->updateAvatar($this->user, $savename)) {
            return $this->sendError('更新失败');
        }

        return $this->sendSuccess($this->user->avatar, '已成功更换头像');
    }

    /**
     * 修改密码
     *
     * @return \think\Response
     */
    public function resetPassword(Request $request)
    {
        $data = $request->post();
        $this->validate($data, [
            'oldPassword' => 'require',
            'newPassword' => 'require',
        ]);

        $this->service->resetPassword($request->user, $data['oldPassword'], $data['newPassword']);

        return $this->sendSuccess(null, '修改成功');
    }
}
