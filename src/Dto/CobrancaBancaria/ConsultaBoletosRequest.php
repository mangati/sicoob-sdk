<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Dto\CobrancaBancaria;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class ConsultaBoletosRequest
{
    public function __construct(
        public readonly string $numeroContrato,
        public readonly int $modalidade,
        public readonly ?int $nossoNumero = null,
        public readonly ?string $linhaDigitavel = null,
        public readonly ?string $codigoBarras = null,
    ) {
    }
}
