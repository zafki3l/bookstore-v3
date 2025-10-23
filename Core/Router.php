<?php

namespace Core;

class Router
{
    private array $routes = [];

    public function get(string $path, mixed $callback) : void
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post(string $path, mixed $callback) : void
    {
        $this->routes['POST'][$path] = $callback;
    }
    
    public function dispatch(string $path, string $method) : void
    {
        if (!isset($this->routes[$method][$path])) {
            die('404 error');
        }

        $callback = $this->routes[$method][$path];

        if (is_array($callback)) {
            [$controller, $action] = $callback;

            $controller = App::resolve($controller);
            $controller->$action();

            return;
        }

        call_user_func($callback);
    }
}