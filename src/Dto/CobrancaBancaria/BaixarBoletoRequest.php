<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Dto\CobrancaBancaria;

use Symfony\Component\Serializer\Attribute\Ignore;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class BaixarBoletoRequest
{
    public function __construct(
        #[Ignore]
        public readonly int $nossoNumero,
        public readonly string $numeroCliente,
        public readonly int $codigoModalidade,
    ) {
    }
}
