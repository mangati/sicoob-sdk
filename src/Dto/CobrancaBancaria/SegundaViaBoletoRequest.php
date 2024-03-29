<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Dto\CobrancaBancaria;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class SegundaViaBoletoRequest
{
    public function __construct(
        public readonly string $numeroContrato,
        public readonly int $modalidade,
        public readonly string $nossoNumero,
        public readonly bool $gerarPdf,
    ) {
    }
}
