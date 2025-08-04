<?php

namespace Modules\Core\Providers;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Modules\Core\app\Providers\CustomExceptionHandler;
use Modules\Core\Exceptions\Filter\ApiExceptionFilter;
use Throwable;

class ExceptionServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void {}

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }
    public function boot(): void
    {
        $this->app->singleton(ExceptionHandler::class, CustomExceptionHandler::class);
        $this->app->booted(function () {
            $handler = $this->app->make(ExceptionHandler::class);

            if (method_exists($handler, 'renderable')) {
                $handler->renderable(function (Throwable $e, Request $request) {
                    return (new ApiExceptionFilter())->__invoke($request, $e);
                });
            }
        });
    }
}
