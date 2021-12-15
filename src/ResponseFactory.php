<?php
declare(strict_types=1);

namespace Elephox\Psr17;

use Elephox\Http\CustomResponseCode;
use Elephox\Http\Response as ElephoxResponse;
use Elephox\Http\ResponseCode;
use Elephox\Psr7\Response as Psr7ResponseAdapter;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface as Psr7Response;

class ResponseFactory implements ResponseFactoryInterface
{
    public function createResponse(int $code = 200, string $reasonPhrase = ''): Psr7Response
    {
        $responseCode = ResponseCode::tryFrom($code);
        $responseCode ??= new CustomResponseCode($code, $reasonPhrase);

        return new Psr7ResponseAdapter(new ElephoxResponse($responseCode));
    }
}
