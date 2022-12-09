<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Dto\ContaCorrente;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class ConsultaExtratoRequest
{
    public function __construct(
        public readonly int $mes,
        public readonly int $ano,
        public readonly int $numeroContaCorrente,
        public readonly ?int $diaInicial = null,
        public readonly ?int $diaFinal = null,
    ) {
    }
}
