<?php

namespace AskPHP\Templating;

use AskPHP\Http\Emitter;
use AskPHP\Http\Response as HttpResponse;

class Response extends HttpResponse
{
    private array $args;
    private string $charset;

    public function __construct()
    {
        parent::__construct(Emitter::$request);
    }

    public function template(array $args): void
    {
        $this->args = $args;
    }

    public function charset(string $charset): void
    {
        $this->charset = $charset;
    }

    public function render(string $name, array $context = null, int $status_code = null)
    {
        $rendering = new Rendering(pathinfo(debug_backtrace(2, 1)[0]['file'], 1));
        list($extends, $class, $method) = $rendering->list($name, $context);
        if (null !== $extends and null !== $class)
            $rendering->template(new $class, $method, $this->args ?? []);
        $rendering->emitter($status_code, $this->charset ?? null);
    }
}
