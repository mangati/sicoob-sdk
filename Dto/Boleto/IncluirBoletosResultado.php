<?php

namespace Mangati\Sicoob\Dto\Boleto;

use Mangati\Sicoob\Model\Boleto\Boleto;

final class IncluirBoletosResultado
{
	public function __construct(
		public readonly ResultadoStatus $status,
		public readonly ?Boleto $boleto,
	)
	{}
}
