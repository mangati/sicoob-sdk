<?php

namespace Mangati\Sicoob\Model\Pix;


final class JurosMulta
{
    public function __construct(
        public readonly int|string $modalidade,
        public readonly string $valorPerc,
    )
    {}
}
