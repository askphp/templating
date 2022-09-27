<?php

namespace AskPHP\Templating;

use stdClass;

class Template
{
    private array $context;
    private string $directory;

    public function __invoke(): stdClass
    {
        return (object)[
            'context' => $this->context,
            'directory' => $this->directory,
        ];
    }

    protected function template(array $context = null): void
    {
        $this->context = $context ?? [];
        $this->directory = pathinfo(debug_backtrace(2, 1)[0]['file'], 1);
    }
}
