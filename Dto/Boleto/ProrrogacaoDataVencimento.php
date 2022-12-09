<?php

namespace Mangati\Sicoob\Dto\Boleto;

use DateTimeInterface;

final class ProrrogacaoDataVencimento
{
    public function __construct(
		public readonly string $numeroContrato,
		public readonly int $modalidade,
		public readonly string $nossoNumero,
		public readonly DateTimeInterface $dataVencimento,
	)
	{}
}
