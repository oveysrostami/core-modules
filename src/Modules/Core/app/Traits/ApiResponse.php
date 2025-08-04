<?php

namespace Modules\Core\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Spatie\QueryBuilder\QueryBuilder;

trait ApiResponse
{
    protected function success(mixed $data = [], string $message = 'core::message.success.done'): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => trans($message),
            'data' => $data,
        ]);
    }

    protected function error(string $errorCode, array $replace = [], int $status = 422, string $namespace = 'core' , $data = []): JsonResponse
    {
        $message = trans($namespace . '::message.errors.' . $errorCode, $replace);

        return response()->json(
            array_merge([
                'status' => false,
                'error' => $errorCode,
                'message' => $message,
            ],config('app.debug') ?  ['debug'=>$data] : [])
            , $status);
    }

    protected function successIndex(QueryBuilder $query, Request $request, string $resourceClass): JsonResponse
    {
        $perPage = $request->input('per_page', 15);
        $collection = $query->paginate($perPage);

        return response()->json([
            'status' => true,
            'message' => trans('core::message.success.list_retrieved'),
            'data' => [
                'items' => $resourceClass::collection($collection),
                'pagination' => [
                    'total' => $collection->total(),
                    'current_page' => $collection->currentPage(),
                    'last_page' => $collection->lastPage(),
                ],
            ]
        ]);
    }

    protected function validationError(array $errors, int $status = 422): JsonResponse
    {
        $message = trans('core::message.errors.validation.failed');
        return response()->json([
            'status' => false,
            'error' => 'validation.failed',
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
}
