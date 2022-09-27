<?php

namespace AskPHP\Routing;

class Route
{
    private string $pattern;
    private array $tokens;

    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
        $this->tokens = [];
    }

    public function tokens(array $tokens): static
    {
        $this->tokens = $tokens;
        return $this;
    }

    public function params(array $handler, string $name, ...$args): void
    {
        Routes::$routes[$name] = (object)[
            'pattern' => $this->pattern,
            'tokens' => $this->tokens,
            'class' => $handler[0],
            'args' => $args,
            'method' => $handler[1],
        ];
    }
}
