<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Model\CobrancaBancaria;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
class SolicitacaoMovimentacao
{
    public function __construct(
        public readonly string $mensagem,
        public readonly int $codigoSolicitacao,
    ) {
    }
}
