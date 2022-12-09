<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Dto\CobrancaBancaria;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class ProrrogarDatasVencimentoRequest
{
    /** @param array<int,ProrrogacaoDataVencimento> $prorrogacoes */
    public function __construct(
        public readonly array $prorrogacoes,
    ) {
    }
}
