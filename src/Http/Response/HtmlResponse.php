<?php

namespace AskPHP\Http\Response;

use AskPHP\Http\Emitter;

class HtmlResponse
{
    public function __construct(string $body, int $status_code = null, string $charset = null)
    {
        $emitter = new Emitter($status_code, 'text/html', $charset);
        $emitter->emit($body);
    }
}
