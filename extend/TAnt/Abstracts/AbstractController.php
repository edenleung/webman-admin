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

namespace TAnt\Abstracts;

use TAnt\Traits\ResponseHelper;
use Psr\Container\ContainerInterface;
use Respect\Validation\Validator;

abstract class AbstractController
{
    use ResponseHelper;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * 验证规则
     * @var array
     */
    protected $rules;

    /**
     * 是否验证数据 (CRUD)
     * @var bool
     */
    protected $dataValidate = false;

    public function __construct(ContainerInterface $container)
    {
        $this->containter = $container;
    }

    public function validate(array $data, array $rules)
    {
        Validator::input($data, $rules);
    }
}
