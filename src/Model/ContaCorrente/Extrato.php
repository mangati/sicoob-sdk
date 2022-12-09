<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Model\ContaCorrente;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class Extrato
{
    /** @param array<int,Transacao> $transacoes */
    public function __construct(
        public readonly string $saldoAtual,
        public readonly string $saldoBloqueado,
        public readonly string $saldoLimite,
        public readonly string $saldoAnterior,
        public readonly array $transacoes,
    ) {
    }
}
