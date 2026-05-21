<?php

namespace App\Helpers;

class Router {
    private array $routes = [
        'GET' => [],
        'POST' => []
    ];

    private array $middleware = [];

    public function get(string $path, string|callable $handler, array $middleware = []): void {
        $this->addRoute('GET', $path, $handler, $middleware);
    }

    public function post(string $path, string|callable $handler, array $middleware = []): void {
        $this->addRoute('POST', $path, $handler, $middleware);
    }

    private function addRoute(string $method, string $path, string|callable $handler, array $routeMiddleware = []): void {
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[a-zA-Z0-9_-]+)', $path);
        $pattern = "#^" . $pattern . "$#";
        $this->routes[$method][$pattern] = $handler;
        $this->middleware[$method][$pattern] = $routeMiddleware;
    }

    private function runMiddleware(array $middleware): void {
        foreach ($middleware as $m) {
            if (is_callable($m)) {
                $m();
            } elseif (is_string($m)) {
                $parts = explode(':', $m);
                $class = "App\\Middleware\\" . $parts[0];
                $params = isset($parts[1]) ? explode(',', $parts[1]) : [];
                if (class_exists($class) && method_exists($class, 'handle')) {
                    $class::handle(...$params);
                }
            }
        }
    }

    public function dispatch(): void {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (!isset($this->routes[$method])) {
            $this->sendNotFound();
            return;
        }

        foreach ($this->routes[$method] as $pattern => $handler) {
            if (preg_match($pattern, $path, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                if (isset($this->middleware[$method][$pattern])) {
                    $this->runMiddleware($this->middleware[$method][$pattern]);
                }

                if (is_callable($handler)) {
                    call_user_func_array($handler, $params);
                } else {
                    $this->invokeController($handler, $params);
                }
                return;
            }
        }

        $this->sendNotFound();
    }

    private function invokeController(string $handler, array $params): void {
        list($controllerName, $methodName) = explode('@', $handler);
        $controllerClass = "App\\Controllers\\" . $controllerName;

        if (class_exists($controllerClass)) {
            $controller = new $controllerClass();
            if (method_exists($controller, $methodName)) {
                call_user_func_array([$controller, $methodName], $params);
                return;
            }
        }

        $this->sendNotFound();
    }

    private function sendNotFound(): void {
        header("HTTP/1.0 404 Not Found");
        $pageTitle = '404 Not Found - MARU';
        ob_start();
        require __DIR__ . '/../../views/pages/404.php';
        $content = ob_get_clean();
        require __DIR__ . '/../../views/layouts/main.php';
        exit;
    }
}
