<?php

namespace AskPHP\Routing;

use AskPHP\Http\Response\PlainResponse;

class Error
{
    public static string $current;

    public function __construct(int $status_code)
    {
        if (isset(self::$current))
            new self::$current($status_code);
        else
            if (404 === $status_code)
                new PlainResponse('Not Found', $status_code);
    }
}
