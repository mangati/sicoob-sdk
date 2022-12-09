<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Model\Pix;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class ValorCobranca
{
    public function __construct(
        public readonly string $original,
        public readonly ?int $modalidadeAlteracao = null,
        public readonly ?JurosMulta $multa = null,
        public readonly ?JurosMulta $juros = null,
    ) {
    }
}
