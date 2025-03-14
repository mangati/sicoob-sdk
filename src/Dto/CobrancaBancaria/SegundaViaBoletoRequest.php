<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Dto\CobrancaBancaria;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class SegundaViaBoletoRequest
{
    public function __construct(
        public readonly int $numeroCliente,
        public readonly int $codigoModalidade,
        public readonly ?int $nossoNumero = null,
        public readonly ?string $linhaDigitavel = null,
        public readonly ?string $codigoBarras = null,
        public readonly ?int $numeroContratoCobranca = null,
        public readonly ?bool $gerarPdf = null,
    ) {
    }
}
