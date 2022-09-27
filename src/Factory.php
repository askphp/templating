<?php

namespace AskPHP;

use AskPHP\Http\Request;

class Factory extends Routing\Router
{
    public static function fromGlobals(string $lang): static
    {
        return new static(new Request($_SERVER, $_GET, $_POST, $_COOKIE, $lang));
    }
}
