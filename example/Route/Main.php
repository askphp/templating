<?php

namespace App\Route;

use AskPHP\Http\Request;

class Main
{
    public function index(Request $request): void
    {
        echo 'Main::index';
    }
}
