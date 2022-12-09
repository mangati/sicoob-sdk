<?php

namespace Mangati\Sicoob\Dto;

use Mangati\Sicoob\Types\TokenScope;


final class TokenRequest
{
	/** @param array<int,TokenScope> $scopes */
	public function __construct(
		public readonly string $clientId,
		public readonly array $scopes,
	)
	{}
}
