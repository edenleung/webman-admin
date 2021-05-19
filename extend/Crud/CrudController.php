<?php

/*
 * This file is part of TAnt.
 * @link     https://github.com/edenleung/think-admin
 * @document https://www.kancloud.cn/manual/thinkphp6_0
 * @contact  QQ Group 996887666
 * @author   Eden Leung 758861884@qq.com
 * @copyright 2019 Eden Leung
 * @license  https://github.com/edenleung/think-admin/blob/6.0/LICENSE.txt
 */

namespace Crud;

use support\Request;
use Crud\CrudService;

trait CrudController
{
    /**
     * @var CrudService
     */
    protected $service;
    
    public function index(Request $request)
    {
        $query = $request->get();

        return $this->sendSuccess($this->service->list($query));
    }

    public function create(Request $request)
    {
        $data = $request->post();
        $this->validate($data, $this->validateRule()['create']);
        $this->service->create($data);

        return $this->sendSuccess();
    }

    public function update(Request $request, $id)
    {
        $data = $request->post();
        $this->validate($data, $this->validateRule()['update']);
        $this->service->update($id, $data);

        return $this->sendSuccess();
    }

    public function delete(Request $request, $id)
    {
        $this->service->delete($id);

        return $this->sendSuccess();
    }

    public function all(Request $request)
    {
        return $this->sendSuccess($this->service->all());
    }

    public function info(Request $request, $id)
    {
        var_dump($id);
        return $this->sendSuccess($this->service->info($id));
    }
}
