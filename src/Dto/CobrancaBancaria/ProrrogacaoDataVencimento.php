<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Dto\CobrancaBancaria;

use DateTimeInterface;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class ProrrogacaoDataVencimento
{
    public function __construct(
        public readonly string $numeroCliente,
        public readonly int $codigoModalidade,
        public readonly string $nossoNumero,
        public readonly DateTimeInterface $dataVencimento,
    ) {
    }
}
