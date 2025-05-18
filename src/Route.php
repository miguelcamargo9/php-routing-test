<?php

namespace App;

class Route
{
    private static array $routes = [];

    public static function resource(string $route): void
    {
        self::$routes[] = $route;
    }

    public static function resolve(string $method, string $uri)
    {
        // Handle the root path ("/")
        if ($uri === '/' || $uri === '') {
            return "Welcome to the PHP Routing Test API";
        }

        // Remove leading slash
        $uri = ltrim($uri, '/');

        // Separate URL segments
        $segments = explode('/', $uri);
        $resource     = $segments[0] ?? null;
        $id           = isset($segments[1]) && is_numeric($segments[1]) ? $segments[1] : null;
        $subResource  = $segments[2] ?? null;
        $subId        = $segments[3] ?? null;

        $routeKey = $resource;
        if ($subResource && in_array("$resource.$subResource", self::$routes, true)) {
            $routeKey = "$resource.$subResource";
        }

        if (!in_array($routeKey, self::$routes, true)) {
            return '404 Not Found';
        }

        return self::dispatch($method, $routeKey, $id, $subResource, $subId);
    }

    private static function dispatch(string $method, string $route, ?string $id, ?string $subResource, ?string $subId)
    {
        $controllerName = self::getControllerName($route);
        $controllerClass = "App\\Controllers\\$controllerName";

        if (!class_exists($controllerClass)) {
            return "404 Controller Not Found";
        }

        $controller = new $controllerClass();
        $method = self::getControllerMethod($method, $id, $subResource, $subId);

        // Determine the parameters to send
        $parameters = [];
        if ($id !== null) $parameters[] = $id;
        if ($subId !== null) $parameters[] = $subId;

        if (!method_exists($controller, $method)) {
            return "404 Method Not Found";
        }

        return call_user_func_array([$controller, $method], $parameters);
    }

    private static function getControllerName(string $route): string
    {
        $parts = explode('.', $route);
        $base  = ucfirst($parts[0]);

        if (isset($parts[1])) {
            return "{$base}" . ucfirst($parts[1]) . "Controller";
        }
        return "{$base}Controller";
    }

    private static function getControllerMethod(
        string $httpMethod,
        ?string $id,
        ?string $subResource,
        ?string $subId
    ): string {
        return match ($httpMethod) {
            'GET'    => $subId ? 'get' : ($subResource ? 'index' : ($id ? 'get' : 'index')),
            'POST'   => 'create',
            'PATCH'  => 'update',
            'DELETE' => 'delete',
            default  => 'index',
        };
    }
}
