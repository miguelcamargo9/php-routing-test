<?php
namespace Tests;

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;

trait TestRequestFactory
{
    private function request(string $method, string $path): RequestInterface|ServerRequestInterface
    {
        $f = new Psr17Factory();
        return (new ServerRequestCreator($f, $f, $f, $f))
            ->fromGlobals()
            ->withMethod($method)
            ->withUri($f->createUri($path));
    }
}
