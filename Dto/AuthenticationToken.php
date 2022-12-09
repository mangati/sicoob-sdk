<?php

namespace Mangati\Sicoob\Dto;

use Mangati\Sicoob\Types\TokenScope;

final class AuthenticationToken
{
    /** @param array<int,TokenScope> $scopes  */
    public function __construct(
        public readonly string $clientId,
        public readonly string $tokenType,
        public readonly string $accessToken,
        public readonly int $expiresIn,
        public readonly int $refreshExpiresIn,
        public readonly array $scopes,
    )
    {}
}
