<?php

namespace Mangati\Sicoob\Model\Pix;

final class InfoAdicional
{
    public function __construct(
        public readonly string $nome,
        public readonly string $valor,
    )
    {}
}
