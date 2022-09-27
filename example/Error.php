<?php

namespace App;

use AskPHP\Http\Response\PlainResponse;

class Error
{
    public function __construct(int $status_code)
    {
        new PlainResponse('App: Not Found', $status_code);
    }
}
