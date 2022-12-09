<?php

namespace Mangati\Sicoob\Dto;


final class TokenResponse
{
	public function __construct(
		public readonly AuthenticationToken $token,
	)
	{}
}
