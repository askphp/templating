<?php

namespace App\Route;

use AskPHP\Http\Request;
use AskPHP\Templating\Response;

class Pages extends Response
{
    public function index(Request $request): void
    {
        $this->render('pages/index', ['name' => $request->get('name', 'Guest')]);
    }

    public function pages(Request $request): void
    {
        $this->template(['title' => 'Pages']);
        $this->charset('utf-8');
        $this->render('pages/pages', ['page' => $request->route('slug')]);
    }
}
