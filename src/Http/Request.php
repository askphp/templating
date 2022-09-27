<?php

namespace AskPHP\Http;

use AskPHP\Routing\Routes;

class Request
{
    public Uri $uri;

    private array $server;
    private array $get;
    private array $post;
    private array $cookie;
    private string $lang;
    private array $route;

    public function __construct(array $server, array $get, array $post, array $cookie, string $lang)
    {
        $this->server = $server;
        $this->get = $get;
        $this->post = $post;
        $this->cookie = $cookie;
        $this->setProperties($server, $lang);
    }

    public function server(string $name): string|null
    {
        return array_key_exists($name, $this->server) ? $this->server[$name] : null;
    }

    public function get(string $name = null, string $default = null): array|string|null
    {
        return null === $name ? $this->get : (
        array_key_exists($name, $this->get) ? $this->get[$name] : $default);
    }

    public function post(string $name = null, string $default = null): array|string|null
    {
        return null === $name ? $this->post : (
        array_key_exists($name, $this->post) ? $this->post[$name] : $default);
    }

    public function cookie(string $name = null, string $default = null): array|string|null
    {
        return null === $name ? $this->cookie : (
        array_key_exists($name, $this->cookie) ? $this->cookie[$name] : $default);
    }

    public function protocol(): float
    {
        return (float)substr($this->server['SERVER_PROTOCOL'], 5);
    }

    public function method(): string
    {
        return strtoupper($this->server['REQUEST_METHOD']);
    }

    public function userIp(): string
    {
        return $this->server['REMOTE_ADDR'];
    }

    public function userAgent(): string
    {
        return $this->server['HTTP_USER_AGENT'];
    }

    private function lang(): string
    {
        return $this->lang;
    }

    public function route(string $name): string|null
    {
        return array_key_exists($name, $this->route) ? $this->route[$name] : null;
    }

    private function setProperties(array $server, string $lang): void
    {
        $this->uri = new Uri($server['REQUEST_SCHEME'] . '://' . $server['HTTP_HOST'] . $server['REQUEST_URI']);
        $this->lang = $lang;
        Routes::$route = [];
        $this->route =& Routes::$route;
    }
}
