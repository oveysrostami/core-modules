<?php

namespace Modules\Core\app\Providers;

use Illuminate\Foundation\Exceptions\Handler as BaseHandler;
use Modules\Core\Exceptions\Filter\ApiExceptionFilter;
use Throwable;

class CustomExceptionHandler extends BaseHandler
{
    protected function shouldReturnJson($request, Throwable $e): bool
    {
        // همیشه JSON بده حتی اگر Accept header نباشه
        return true;
    }

    public function render($request, Throwable $e)
    {
        return (new ApiExceptionFilter())->__invoke($request, $e);
    }
}
