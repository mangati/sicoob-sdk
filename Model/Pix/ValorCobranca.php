<?php

namespace Mangati\Sicoob\Model\Pix;


final class ValorCobranca
{
    public function __construct(
        public readonly string $original,
        public readonly ?JurosMulta $multa = null,
        public readonly ?JurosMulta $juros = null,
    )
    {}
}
