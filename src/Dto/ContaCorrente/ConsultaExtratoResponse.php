<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Dto\ContaCorrente;

use Mangati\Sicoob\Model\ContaCorrente\Extrato;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class ConsultaExtratoResponse
{
    /** @param array<int,string> $mensagens */
    public function __construct(
        public readonly array $mensagens,
        public readonly Extrato $resultado,
    ) {
    }
}
