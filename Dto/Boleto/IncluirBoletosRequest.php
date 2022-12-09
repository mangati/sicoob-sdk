<?php

namespace Mangati\Sicoob\Dto\Boleto;

use Mangati\Sicoob\Model\Boleto\Boleto;

final class IncluirBoletosRequest
{
	/** @param array<int,Boleto> $boletos */
	public function __construct(
		public readonly array $boletos,
	)
	{}
}
