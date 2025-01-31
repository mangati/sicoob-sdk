<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Dto\CobrancaBancaria;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class BaixarBoletoMensagem
{
    public function __construct(
        public readonly string $mensagem,
        public readonly int|string $codigo,
    ) {
    }
}
