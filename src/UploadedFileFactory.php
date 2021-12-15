<?php
declare(strict_types=1);

namespace Elephox\Psr17;

use Elephox\Http\UploadedFile;
use Elephox\Http\UploadError;
use Elephox\Psr7\Stream;
use Elephox\Psr7\UploadedFile as Psr7UploadedFile;
use Elephox\Support\CustomMimeType;
use Elephox\Support\MimeType;
use InvalidArgumentException;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UploadedFileInterface;
use const UPLOAD_ERR_OK;

class UploadedFileFactory implements UploadedFileFactoryInterface
{
    public function createUploadedFile(StreamInterface $stream, int $size = null, int $error = UPLOAD_ERR_OK, string $clientFilename = null, string $clientMediaType = null): UploadedFileInterface
    {
        if (!$stream->isReadable()) {
            throw new InvalidArgumentException('Stream must be readable.');
        }

        $mimeType = MimeType::tryFrom($clientMediaType);
        $mimeType ??= new CustomMimeType($clientMediaType);

        $uploadError = UploadError::from($error);

        $contentStream = Stream::toElephoxStream($stream);

        return new Psr7UploadedFile(new UploadedFile($clientFilename, sys_get_temp_dir() . DIRECTORY_SEPARATOR . $clientFilename, $contentStream, $mimeType, $size, $uploadError));
    }
}
