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
        $resource = $segments[0] ?? null;
        $subResource = $segments[1] ?? null;
        $id = isset($segments[1]) && is_numeric($segments[1]) ? $segments[1] : null;
        $subId = isset($segments[3]) ? $segments[3] : null;

        foreach (self::$routes as $route) {
            if (str_starts_with($route, $resource)) {
                return self::dispatch($method, $route, $id, $subResource, $subId);
            }
        }

        return "404 Not Found";
    }

    private static function dispatch(string $method, string $route, ?string $id, ?string $subResource, ?string $subId)
    {
        $controllerName = self::getControllerName($route, $subResource);
        $controllerClass = "App\\Controllers\\{$controllerName}";

        if (!class_exists($controllerClass)) {
            return "404 Controller Not Found";
        }

        $controller = new $controllerClass();
        $method = self::getControllerMethod($method, $id, $subId);
        if (!method_exists($controller, $method)) {
            return "404 Method Not Found";
        }

        return call_user_func_array([$controller, $method], array_filter([$id, $subId]));
    }

    private static function getControllerName(string $route, ?string $subResource): string
    {
        $parts = explode('.', $route);
        $base = ucfirst($parts[0]);
        return $subResource ? "{$base}MetricsController" : "{$base}Controller";
    }

    private static function getControllerMethod(string $method, ?string $id, ?string $subId): string
    {
        return match ($method) {
            'GET' => $subId ? 'get' : ($id ? 'get' : 'index'),
            'POST' => 'create',
            'PATCH' => 'update',
            'DELETE' => 'delete',
            default => 'index',
        };
    }
}
