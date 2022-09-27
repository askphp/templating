<?php

namespace AskPHP\Http\Response;

use AskPHP\Http\Emitter;

class JsonResponse
{
    public function __construct(array $data, int $status_code = null)
    {
        $emitter = new Emitter($status_code, 'application/json', '');
        $emitter->emit($emitter->dataToJson($data));
    }
}
