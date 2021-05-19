<?php

namespace app;

use Webman\Http\Request;
use Webman\Http\Response;
use Throwable;
use Webman\Exception\ExceptionHandler;
use Respect\Validation\Exceptions\ValidationException;
use TAnt\Exception\SystemException;

/**
 * Class Handler
 * @package support\exception
 */
class BaseExceptionHandler extends ExceptionHandler
{
    public $dontReport = [
        BusinessException::class,
    ];

    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    public function render(Request $request, Throwable $exception) : Response
    {
        // 添加自定义异常处理机制

        // 数据验证异常
        if ($exception instanceof ValidationException) {
            return json(['message' => $exception->getMessage(), 'code' => 50015]);
        }

        // 业务异常
        if ($exception instanceof SystemException) {
            return json(['message' => $exception->getMessage(), 'code' => $exception->getCode()]);
        }

        return parent::render($request, $exception);
    }

}