<?php
declare(strict_types=1);

namespace Elephox\Psr17;

use Elephox\Http\Url as ElephoxUri;
use Elephox\Psr7\Uri as Psr7UriAdapter;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface as Psr7Uri;

class UriFactory implements UriFactoryInterface
{
    public function createUri(string $uri = ''): Psr7Uri
    {
        return new Psr7UriAdapter(ElephoxUri::fromString($uri));
    }
}
