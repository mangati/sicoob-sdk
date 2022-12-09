<?php

namespace Mangati\Sicoob\Dto\Boleto;


final class SegundaViaBoletoRequest
{

	public function __construct(
		public readonly string $numeroContrato,
		public readonly int $modalidade,
		public readonly string $nossoNumero,
		public readonly bool $gerarPdf,
	)
	{}
}
