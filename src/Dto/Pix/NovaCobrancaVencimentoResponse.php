<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Dto\Pix;

use Mangati\Sicoob\Model\Pix\CalendarioVencimento;
use Mangati\Sicoob\Model\Pix\InfoAdicional;
use Mangati\Sicoob\Model\Pix\Pessoa;
use Mangati\Sicoob\Model\Pix\ValorCobranca;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class NovaCobrancaVencimentoResponse
{
    /** @param array<int,InfoAdicional> $infoAdicionais */
    public function __construct(
        public readonly CalendarioVencimento $calendario,
        public readonly string $status,
        public readonly string $txid,
        public readonly Pessoa $devedor,
        public readonly Pessoa $recebedor,
        public readonly ValorCobranca $valor,
        public readonly string $chave,
        public readonly string $solicitacaoPagador,
        public readonly string $brcode,
        public readonly ?array $infoAdicionais = [],
    ) {
    }
}
