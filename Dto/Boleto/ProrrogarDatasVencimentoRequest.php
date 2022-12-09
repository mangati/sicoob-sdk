<?php

namespace Mangati\Sicoob\Dto\Boleto;


final class ProrrogarDatasVencimentoRequest
{
	/** @param array<int,ProrrogacaoDataVencimento> $prorrogacoes */
	public function __construct(
		public readonly array $prorrogacoes,
	)
	{}
}
