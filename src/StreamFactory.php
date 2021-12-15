<?php
declare(strict_types=1);

namespace Elephox\Psr17;

use Elephox\Psr7\Stream as Psr7Stream;
use Elephox\Stream\ResourceStream;
use Elephox\Stream\StringStream;
use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

class StreamFactory implements StreamFactoryInterface
{
    #[Pure] public function createStream(string $content = ''): StreamInterface
    {
        return new Psr7Stream(new StringStream($content));
    }

    public function createStreamFromFile(string $filename, string $mode = 'rb'): StreamInterface
    {
        return $this->createStreamFromResource(fopen($filename, $mode));
    }

    public function createStreamFromResource($resource): StreamInterface
    {
        return new Psr7Stream(new ResourceStream($resource));
    }
}
