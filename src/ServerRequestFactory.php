<?php
declare(strict_types=1);

namespace Elephox\Psr17;

use Elephox\Http\CustomRequestMethod;
use Elephox\Http\ServerRequest as ElephoxServerRequest;
use Elephox\Http\RequestMethod;
use Elephox\Http\Url;
use Elephox\Psr7\ServerRequest as Psr7ServerRequestAdapter;
use Elephox\Psr7\Uri;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

class ServerRequestFactory extends RequestFactory implements ServerRequestFactoryInterface
{
    public function createServerRequest(string $method, $uri, array $serverParams = []): ServerRequestInterface
    {
        $requestMethod = RequestMethod::tryFrom($method);
        $requestMethod ??= new CustomRequestMethod($method);

        if ($uri instanceof UriInterface) {
            $url = Uri::toElephox($uri);
        } else {
            $url = Url::fromString($uri);
        }

        // TODO: add server params

        return new Psr7ServerRequestAdapter(new ElephoxServerRequest($requestMethod, $url));
    }
}
