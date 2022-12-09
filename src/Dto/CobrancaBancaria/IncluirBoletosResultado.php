<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Dto\CobrancaBancaria;

use Mangati\Sicoob\Model\CobrancaBancaria\Boleto;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class IncluirBoletosResultado
{
    public function __construct(
        public readonly ResultadoStatus $status,
        public readonly ?Boleto $boleto,
    ) {
    }
}
