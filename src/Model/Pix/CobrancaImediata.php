<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Model\Pix;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class CobrancaImediata
{
    /** @param InfoAdicional[] $infoAdicionais */
    public function __construct(
        public readonly CalendarioSimples $calendario,
        public readonly Pessoa $devedor,
        public readonly ValorCobranca $valor,
        public readonly string $chave,
        public readonly string $solicitacaoPagador,
        public readonly array $infoAdicionais,
    ) {
    }
}
