<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Dto;

use Mangati\Sicoob\Types\TokenScope;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
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
        public readonly bool $isSandbox = false,
    ) {
    }
}
