<?php

namespace App\Template;

use AskPHP\Templating\Template;

class Render extends Template
{
    public function base(): void
    {
        $this->template([
            'title' => 'Render'
        ]);
    }
}
