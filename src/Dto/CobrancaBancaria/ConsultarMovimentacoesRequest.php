<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Dto\CobrancaBancaria;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class ConsultarMovimentacoesRequest
{
    public function __construct(
        public readonly int $numeroCliente,
        public readonly int $codigoSolicitacao,
    ) {
    }
}
