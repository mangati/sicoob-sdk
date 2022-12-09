<?php

namespace Mangati\Sicoob\Exception;

use Exception;

final class SicoobException extends Exception
{
    /** @param array<mixed>|null $body */
    public function __construct(
        private readonly int $statusCode,
        private readonly ?array $body,
    ) {
        parent::__construct('SicoobException');
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /** @return array<mixed>|null */
    public function getBody(): ?array
    {
        return $this->body;
    }
}
