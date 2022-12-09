<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Dto\CobrancaBancaria;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class IncluirBoletosResponse
{
    /** @param array<int,IncluirBoletosResultado> $resultado */
    public function __construct(
        public readonly array $resultado,
    ) {
    }
}
