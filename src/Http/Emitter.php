<?php

namespace AskPHP\Http;

class Emitter
{
    public static Request $request;
    public static string $class;
    public static array $methods;
    public static array $headers;
    public static array $cookies;

    private int|null $status_code;
    private string $mime_type;
    private string|null $charset;

    public function __construct(int|null $status_code, string $mime_type, string|null $charset)
    {
        $this->status_code = $status_code ?? 200;
        $this->mime_type = $mime_type;
        $charset = null === $charset ? 'UTF-8' : $charset;
        $this->charset = $charset ? '; charset=' . $charset : $charset;
    }

    public function dataToJson(array $data): string
    {
        $json = json_encode($data);
        if (false === $json) $json = json_encode(['jsonError' => json_last_error_msg()]);
        if (false === $json) {
            $this->status_code = 500;
            $json = '{"jsonError":"Unknown error"}';
        }
        return $json;
    }

    public function emit(string $body): void
    {
        http_response_code($this->status_code);
        header('Content-Type: ' . $this->mime_type . $this->charset);
        foreach (self::$headers ?? [] as $key => $value)
            header($key . ': ' . $value);
        foreach (self::$cookies ?? [] as $cookie) {
            header($cookie, false);
        }
        echo $body;
    }
}
