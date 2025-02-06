<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Exception;

use Exception;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class SicoobException extends Exception
{
    public function __construct(
        private readonly string $url,
        private readonly int $statusCode,
        private readonly ?string $body,
    ) {
        parent::__construct(sprintf(
            'SicoobException: body=%s, statusCode=%s, url=%s',
            $body,
            $statusCode,
            $url,
        ));
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }
}
