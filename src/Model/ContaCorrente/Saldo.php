<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Model\ContaCorrente;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class Saldo
{
    public function __construct(
        public readonly string $saldo,
        public readonly string $saldoLimite,
        public readonly string $saldoBloqueado,
    ) {
    }
}
