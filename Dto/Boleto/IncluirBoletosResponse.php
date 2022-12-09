<?php

namespace Mangati\Sicoob\Dto\Boleto;

final class IncluirBoletosResponse
{
	/** @param array<int,IncluirBoletosResultado> $resultado */
	public function __construct(
		public readonly array $resultado,
	)
	{}
}
