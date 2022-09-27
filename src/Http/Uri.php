<?php

namespace AskPHP\Http;

class Uri
{
    private string $scheme;
    private string $host;
    private string $path;
    private string $query;
    private string $fragment;

    public function __construct(string $uri)
    {
        $part = parse_url(urldecode($uri));
        $scheme = strtolower($part['scheme']);
        if (!in_array($scheme, ['http', 'https']))
            throw new Exception\InvalidUriException(sprintf(
                'Схема "%s" недействительна или не принята в %s',
                $scheme, self::class
            ));
        $this->scheme = $scheme;
        $this->host = strtolower($part['host']);
        $this->path = $part['path'];
        $this->query = isset($part['query']) ? '?' . $part['query'] : '';
        $this->fragment = isset($part['fragment']) ? '#' . $part['fragment'] : '';
    }

    public function scheme(): string
    {
        return $this->scheme;
    }

    public function host(): string
    {
        return $this->host;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function query(): string
    {
        return $this->query;
    }

    public function fragment(): string
    {
        return $this->fragment;
    }
}
