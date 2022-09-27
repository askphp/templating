<?php

namespace AskPHP\Routing;

use AskPHP\Http\Emitter;
use AskPHP\Http\Request;

class Router
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function route(string $pattern): Route
    {
        return new Route($pattern);
    }

    public function render(...$args): void
    {
        foreach ($args as $key => list($class, $method)) {
            if (0 === $key)
                Emitter::$class = $class;
            Emitter::$methods[] = $method;
        }
    }

    public function run(string $error = null): void
    {
        if (null !== $error)
            Error::$current = $error;
        Emitter::$methods = Emitter::$methods ?? [];
        new Routes($this->request);
    }
}
