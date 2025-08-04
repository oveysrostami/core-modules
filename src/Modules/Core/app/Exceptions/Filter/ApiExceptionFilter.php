<?php

namespace Modules\Core\Exceptions\Filter;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Modules\Core\Exceptions\ApiException;
use Modules\Core\Traits\ApiResponse;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ApiExceptionFilter extends Exception {
    use ApiResponse;
    public function __invoke(Request $request, Throwable $e): mixed
    {
        /*if (!$request->expectsJson()) {
            return null;
        }*/
        if($e instanceof ApiException) {
            return $this->error($e->errorCode,$e->replace,$e->status,$e->translationNamespace);
        }

        if ($e instanceof ValidationException) {
            return $this->validationError($e->errors());
        }

        if ($e instanceof AuthenticationException) {
            return $this->error('auth.unauthenticated', [], 401,'core',['trace' => $e->getTrace() ,'message'=>$e->getMessage()]);
        }

        if ($e instanceof UnauthorizedException){
            return $this->error('auth.unauthorized', [], 401,'core',['trace' => $e->getTrace() ,'message'=>$e->getMessage()]);
        }

        if($e instanceof ThrottleRequestsException){
            return $this->error('server.throttle', [], 408,'core',['trace' => $e->getTrace() ,'message'=>$e->getMessage()]);
        }

        if ($e instanceof AuthorizationException) {
            return $this->error('auth.unauthorized', [], 403,'core',['trace' => $e->getTrace() ,'message'=>$e->getMessage()]);
        }

        if ($e instanceof AccessDeniedHttpException) {
            return $this->error('auth.access_denied', [],403,'core',['trace' => $e->getTrace() ,'message'=>$e->getMessage()]);
        }

        if ($e instanceof NotFoundHttpException) {
            return $this->error('routing.not_found',[],404,'core',['trace' => $e->getTrace() ,'message'=>$e->getMessage()]);
        }
        if($e instanceof ModelNotFoundException){
            return $this->error('model.not_found',[],404,'core',['trace' => $e->getTrace() ,'message'=>$e->getMessage()]);
        }
        if($e instanceof MethodNotAllowedHttpException){
            return $this->error('routing.method_not_allowed',[],405,'core',['trace' => $e->getTrace() ,'message'=>$e->getMessage()]);
        }

        // سایر خطاهای عمومی
        return $this->error('server.error', [],500,'core' ,  ['trace' => $e->getTrace() ,'message'=>$e->getMessage()]);
    }
}
