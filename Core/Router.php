<?php

class Router
{
    private array $routes = [];

    public function get(string $path, callable $callback) : void
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post(string $path, string $callback) : void
    {
        $this->routes['POST'][$path] = $callback;
    }
    
    public function dispatch(string $path, string $method) : void
    {
        if (!isset($this->routes[$method][$path])) {
            die('404 error');
        }

        call_user_func($this->routes[$method][$path]);
    }
}