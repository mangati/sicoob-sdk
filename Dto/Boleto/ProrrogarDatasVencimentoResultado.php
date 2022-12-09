<?php

namespace Mangati\Sicoob\Dto\Boleto;


final class ProrrogarDatasVencimentoResultado
{
	public function __construct(
		public readonly ResultadoStatus $status,
		public readonly ?ProrrogacaoDataVencimento $prorrogacao,
	)
	{}
}
