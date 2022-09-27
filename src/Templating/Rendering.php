<?php

namespace AskPHP\Templating;

use AskPHP\Http\Emitter;

class Rendering
{
    private string $directory;
    private string $filepath;
    private array $context;
    private string $body;
    private string $extends;

    public function __construct(string $directory)
    {
        $this->directory = $directory;
    }

    public function list(string $name, array|null $context): array
    {
        $body = function () {
            extract($this->context);
            ob_start();
            require $this->filepath;
            return trim(ob_get_clean());
        };
        if (!file_exists($filepath = $this->directory . '/templates/' . $name . '.php'))
            throw new Exception\InvalidRenderingException(sprintf(
                'Отсутствует файл %s в %s',
                $filepath, self::class
            ));
        $this->filepath = $filepath;
        $this->context = $context ?? [];
        $this->body = $body();
        if (preg_match('~(?<=\{% extends)(.*?)(?=%})~', $this->body, $matches)) {
            $this->extends = trim($matches[1]);
            $method = explode('.', explode('/', $this->extends)[0])[0];
            $this->body = trim(preg_replace('~\{% extends' . $matches[1] . '%}~', '', $this->body));
        }
        return [$this->extends ?? null, Emitter::$class ?? null, $method ?? null];
    }

    public function template(object $class, string $method, array $args): void
    {
        if (!in_array($method, Emitter::$methods))
            throw new Exception\InvalidRenderingException(sprintf(
                'Неопределен метод %s полученный из файла %s в %s',
                Emitter::$class . '->' . $method . '()', $this->filepath, self::class
            ));
        $class->$method();
        if (!is_callable($class))
            throw new Exception\InvalidRenderingException(sprintf(
                'В классе %s отсутствует метод обратного вызова (__invoke), в %s',
                Template::class, self::class
            ));
        else
            $this->body($class, $args);
    }

    public function emitter(int|null $status_code, string|null $charset): void
    {
        $emitter = new Emitter($status_code, 'text/html', $charset);
        $emitter->emit($this->body);
    }

    private function body(callable $class, array $args): void
    {
        $template = $class();
        if (!file_exists($filepath = $template->directory . '/templates/' . $this->extends))
            throw new Exception\InvalidRenderingException(sprintf(
                'Отсутствует файл %s в %s',
                $filepath, self::class
            ));
        $search = [];
        $replace = [];
        foreach ((['body' => $this->body] + $args + $template->context) as $key => $value) {
            $search[] = '{{ ' . $key . ' }}';
            $replace[] = $value;
        }
        $this->body= trim(str_replace($search, $replace, file_get_contents($filepath)));
    }
}
