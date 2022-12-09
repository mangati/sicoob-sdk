<?php

namespace Mangati\Sicoob\Dto\Pix;

use Mangati\Sicoob\Model\Pix\Pix;

final class ConsultaPixResponse
{
    /** @param array<int,Pix> $pix */
    public function __construct(
        public readonly array $pix,
    )
    {}
}
