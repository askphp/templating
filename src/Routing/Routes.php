<?php

namespace AskPHP\Routing;

use AskPHP\Http\Emitter;
use AskPHP\Http\Request;
use AskPHP\Http\Response;

class Routes
{
    public static array $routes;
    public static array $route;

    private array $list;

    public function __construct(Request $request)
    {
        if ($this->math($request)) {
            list($class, $args, $method) = $this->list;
            if ($response = is_subclass_of($class, Response::class))
                Emitter::$request = $request;
            $response ?
                (new $class(...$args))->$method($request) :
                (new $class(...$args))->$method($request, new Response($request));
        } else {
            new Error(404);
        }
    }

    private function math(Request $request): bool
    {
        foreach (self::$routes as $route) {
            $pattern = preg_replace_callback('~\{([^}]+)}~', function ($matches) use ($route) {
                $arg = $matches[1];
                $replace = $route->tokens[$arg] ?? '[^}]+';
                return '(?P<' . $arg . '>' . $replace . ')';
            }, $route->pattern);
            if (preg_match('~^' . $pattern . '$~i', $request->uri->path(), $matches)) {
                self::$route = array_filter($matches, '\is_string', ARRAY_FILTER_USE_KEY);
                $this->list = [$route->class, $route->args, $route->method];
                break;
            }
        }
        return isset($this->list);
    }
}
