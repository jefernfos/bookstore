<?php

namespace Core;

class Router
{
    private $routes = [];

    public function __construct(private Container $container)
    {
    }

    // Add a route to the router
    public function add($method, $path, $callback)
    {
        $path = "#^" . preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $path) . "$#";
        $this->routes[] = compact('method', 'path', 'callback');
    }

    // Resolve the route based on the request method and URI
    public function resolve()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if ($method === $route['method'] && preg_match($route['path'], $uri, $matches)) {
                $callback = $route['callback'];
                $args = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                if (is_array($callback)) {
                    [$class, $function] = $callback;
                    $instance = $this->container->get($class);

                    return call_user_func([$instance, $function], $args);
                }

                return call_user_func($callback, $args);
            }
        }

        header('Location: /404');
    }
}