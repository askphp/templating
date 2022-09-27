<?php

namespace AskPHP\Http;

use DateTimeInterface;

class Response
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function setHeader(string $name, string $value = null): void
    {
        Emitter::$headers[$name] = $value;
    }

    public function delHeader(string $name): void
    {
        unset(Emitter::$headers[$name]);
    }

    public function setCookie(
        string $name,
        string $value = null,
        int    $expires = null,
        string $path = null,
        string $domain = null,
        bool   $secure = false,
        bool   $httpOnly = false,
        string $sameSite = null): void
    {
        Emitter::$cookies[] = 'Set-Cookie: ' . $name . '=' . ($value ?? '')
            . (null === $expires ? '' : '; expires=' . gmdate(DateTimeInterface::COOKIE, $expires))
            . (null === $path ? '' : '; path=' . $path)
            . (null === $domain ? '' : '; domain=' . $domain)
            . (!$secure ? '' : '; Secure')
            . (!$httpOnly ? '' : '; HttpOnly')
            . ((null === $sameSite or !in_array($sameSite, ['Lax', 'Strict'])) ? '' : '; SameSite=' . $sameSite);
    }

    public function delCookie(string $name, string $path = null, string $domain = null): void
    {
        Emitter::$cookies[] = 'Set-Cookie: ' . $name . '=; expires='
            . gmdate(DateTimeInterface::COOKIE, 0)
            . (null === $path ? '' : '; path=' . $path)
            . (null === $domain ? '' : '; domain=' . $domain);
    }

    public function redirect(string $location, int $response_code = null): void
    {
        header(
            header: 'Location: ' . $location,
            response_code: $response_code ?? (1.0 === $this->request->protocol() ? 302 : 307)
        );
    }
}
