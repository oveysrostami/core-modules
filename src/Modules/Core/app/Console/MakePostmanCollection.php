<?php

namespace Modules\Core\Console;

use Illuminate\Console\Command;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use ReflectionException;

class MakePostmanCollection extends Command
{
    protected $signature = 'app:make-postman-collection';

    protected $description = 'Generate Postman collection for API routes';

    /**
     * @throws ReflectionException
     */
    public function handle(): void
    {
        $routes = collect(Route::getRoutes()->getRoutes())
            ->filter(fn($route) => Str::startsWith($route->uri(), 'api/'));

        $folders = [];
        $authScopes = collect();

        foreach ($routes as $route) {
            $middlewares = $route->gatherMiddleware();
            $scope = 'Public';
            foreach ($middlewares as $middleware) {
                if (Str::startsWith($middleware, 'scope:')) {
                    $scope = Str::title(Str::after($middleware, 'scope:'));
                    break;
                }
                if (Str::startsWith($middleware, 'scopes:')) {
                    $scope = Str::title(Str::before(Str::after($middleware, 'scopes:'), ','));
                    break;
                }
            }

            $action = $route->getActionName();
            if ($action === 'Closure') {
                continue;
            }

            [$controller] = explode('@', $action);
            $module = Str::startsWith($controller, 'Modules\\')
                ? Str::of($controller)->explode('\\')[1]
                : 'App';

            $controllerName = class_basename($controller);
            $resource = preg_replace('/Controller.*/', '', $controllerName);
            $resource = trim(collect(preg_split('/(?=[A-Z])/', $resource))->implode(' '));

            $routeName = $route->getName() ?: $route->uri();
            $actionName = Str::of($routeName)->explode('.')->last();
            $actionTitle = Str::of($actionName)->replace('-', ' ')->title();
            $method = $route->methods()[0];

            $headers = [
                ['key' => 'Accept', 'value' => 'application/json'],
            ];

            $body = null;
            if (in_array($method, ['POST', 'PUT', 'PATCH'])) {
                [$controllerClass, $controllerMethod] = explode('@', $action);
                $reflection = new \ReflectionMethod($controllerClass, $controllerMethod);
                foreach ($reflection->getParameters() as $parameter) {
                    $type = $parameter->getType();
                    if ($type && !$type->isBuiltin()) {
                        $class = new \ReflectionClass($type->getName());
                        if ($class->isSubclassOf(FormRequest::class)) {
                            /** @var FormRequest $form */
                            $formClass = $type->getName();
                            $form = new $formClass();
                            $rules = $form->rules();
                            $body = collect($rules)->mapWithKeys(function ($rule, $field) {
                                $ruleString = is_array($rule) ? implode('|', $rule) : $rule;
                                if (Str::contains($ruleString, ['integer', 'numeric'])) {
                                    $value = 0;
                                } elseif (Str::contains($ruleString, 'boolean')) {
                                    $value = true;
                                } elseif (Str::contains($ruleString, 'array')) {
                                    $value = [];
                                } else {
                                    $value = '';
                                }
                                return [$field => $value];
                            })->toArray();
                            break;
                        }
                    }
                }
            }

            $request = [
                'name' => $actionTitle,
                'request' => [
                    'method' => $method,
                    'header' => $headers,
                    'url' => [
                        'raw' => "{{base_url}}/" . $route->uri(),
                        'host' => ['{{base_url}}'],
                        'path' => explode('/', $route->uri()),
                    ],
                ],
            ];
            $requiresAuth = collect($middlewares)->contains(fn($m) => Str::startsWith($m, 'auth:'));
            if ($requiresAuth) {
                $tokenVar = Str::lower($scope) . '_token';
                $request['request']['auth'] = [
                    'type' => 'bearer',
                    'bearer' => [
                        ['key' => 'token', 'value' => '{{' . $tokenVar . '}}', 'type' => 'string'],
                    ],
                ];
                $authScopes->push($tokenVar);
            }
            if ($body !== null) {
                $request['request']['body'] = [
                    'mode' => 'raw',
                    'raw' => json_encode($body, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
                    'options' => [
                        'raw' => [
                            'language' => 'json',
                        ],
                    ],
                ];
            }

            if (Str::contains($route->uri(), 'login')) {
                $controllerClassName = class_basename($controller);
                $tokenVar = Str::of($controllerClassName)
                    ->replace('AuthController', '')
                    ->lower()
                    ->append('_token');
                $request['event'][] = [
                    'listen' => 'test',
                    'script' => [
                        'type' => 'text/javascript',
                        'exec' => [
                            "var res = pm.response.json();",
                            "if(res.status)",
                            "pm.collectionVariables.set('{$tokenVar}', res.data.token.access_token);",
                        ],
                    ],
                ];
            }

            $folders[$scope][$module][$resource][] = $request;
        }

        $collection = [
            'info' => [
                'name' => config('app.name') . ' API',
                'schema' => 'https://schema.getpostman.com/json/collection/v2.1.0/collection.json',
            ],
            'item' => [],
            'variable' => collect([
                ['key' => 'base_url', 'value' => config('app.url')],
            ])->merge(
                $authScopes->unique()->map(fn($key) => ['key' => $key, 'value' => ''])
            )->values()->all(),
        ];

        foreach ($folders as $scopeName => $modules) {
            $scopeItem = ['name' => $scopeName, 'item' => []];
            foreach ($modules as $moduleName => $resources) {
                $moduleItem = ['name' => $moduleName, 'item' => []];
                foreach ($resources as $resourceName => $requests) {
                    $moduleItem['item'][] = ['name' => $resourceName, 'item' => $requests];
                }
                $scopeItem['item'][] = $moduleItem;
            }
            $collection['item'][] = $scopeItem;
        }

        $path = storage_path('app/postman.json');
        file_put_contents($path, json_encode($collection, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        $this->info("Postman collection generated at: {$path}");
    }
}
