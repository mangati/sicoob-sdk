<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Dto\ContaCorrente;

use Mangati\Sicoob\Model\ContaCorrente\Saldo;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class ConsultaSaldoResponse
{
    /** @param array<int,string> $mensagens */
    public function __construct(
        public readonly array $mensagens,
        public readonly Saldo $resultado,
    ) {
    }
}
