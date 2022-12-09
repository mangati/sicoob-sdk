<?php

namespace Mangati\Sicoob\Dto\Boleto;

final class ResultadoStatus
{
	public function __construct(
		public readonly int $codigo,
		public readonly ?string $mensagem = null,
	)
	{}
}
