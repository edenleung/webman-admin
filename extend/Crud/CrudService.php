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

use TAnt\Abstracts\AbstractService;

abstract class CrudService extends AbstractService
{
    protected $model;

    /**
     * @return \think\Collection
     */
    public function list(array $query)
    {
        return call_user_func_array([$this->model, 'list'], $query);
    }

    /**
     * @return bool
     */
    public function create(array $data)
    {
        return (new $this->model)->save($data);
    }

    /**
     * @return BaseModel
     */
    public function update($id, array $data)
    {
        $row = $this->info($id);

        return $row->save($data);
    }

    /**
     * @return bool
     */
    public function delete($id)
    {
        $row = $this->info($id);

        return $row->delete();
    }

    /**
     * @return BaseModel
     */
    public function info($id)
    {
        $row = call_user_func_array([$this->model, 'detail'], [$id]);

        if ($row) {
            return $row;
        }

        exception('没有此记录');
    }

    /**
     * @return \think\Collection
     */
    public function all()
    {
        return (new $this->model)->all();
    }
}
