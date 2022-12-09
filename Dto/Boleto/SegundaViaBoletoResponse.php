<?php

namespace Mangati\Sicoob\Dto\Boleto;

use Mangati\Sicoob\Model\Boleto\Boleto;


final class SegundaViaBoletoResponse
{

	public function __construct(
		public readonly Boleto $resultado,
	)
	{}
}
