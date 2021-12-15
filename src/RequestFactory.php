<?php
declare(strict_types=1);

namespace Elephox\Psr17;

use Elephox\Http\CustomRequestMethod;
use Elephox\Http\Request as ElephoxRequest;
use Elephox\Http\RequestMethod;
use Elephox\Http\Url;
use Elephox\Psr7\Request as Psr7RequestAdapter;
use Elephox\Psr7\Uri;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface as Psr7Request;
use Psr\Http\Message\UriInterface;

class RequestFactory implements RequestFactoryInterface
{
    public function createRequest(string $method, $uri): Psr7Request
    {
        $requestMethod = RequestMethod::tryFrom($method);
        $requestMethod ??= new CustomRequestMethod($method);

        if ($uri instanceof UriInterface) {
            $url = Uri::toElephox($uri);
        } else {
            $url = Url::fromString($uri);
        }

        return new Psr7RequestAdapter(new ElephoxRequest($requestMethod, $url));
    }
}
