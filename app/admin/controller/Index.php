<?php

namespace app\admin\controller;

use support\Request;

class Index
{
    public function index(Request $request)
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1', 6379);
        echo "Connection to server successfully";
        //查看服务是否运行
        echo "Server is running: " . $redis->ping();

        // $redis->set('test', 10);
        if ($redis->get('test') <= 0) {
            var_dump('没了');
        } else {
            var_dump($redis->decr('test'));
        }
        return response('hello webman');
    }

    public function view(Request $request)
    {
        return view('index/view', ['name' => 'webman']);
    }

    public function json(Request $request)
    {
        return json(['code' => 0, 'msg' => 'ok']);
    }

    public function file(Request $request)
    {
        $file = $request->file('upload');
        if ($file && $file->isValid()) {
            $file->move(public_path() . '/files/myfile.' . $file->getUploadExtension());
            return json(['code' => 0, 'msg' => 'upload success']);
        }
        return json(['code' => 1, 'msg' => 'file not found']);
    }
}
