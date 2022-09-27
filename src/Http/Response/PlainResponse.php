<?php

namespace AskPHP\Http\Response;

use AskPHP\Http\Emitter;

class PlainResponse
{
    public function __construct(string $string, int $status_code = null, string $charset = null)
    {
        $emitter = new Emitter($status_code, 'text/plain', $charset);
        $emitter->emit($string);
    }
}
