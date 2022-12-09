<?php

namespace Mangati\Sicoob\Dto\Boleto;

final class ProrrogarDatasVencimentoResponse
{
	/** @param array<int,ProrrogarDatasVencimentoResultado> $resultado */
	public function __construct(
		public readonly array $resultado,
	)
	{}
}
