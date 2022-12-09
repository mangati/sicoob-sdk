<?php

namespace Mangati\Sicoob\Dto\Pix;

use DateTimeInterface;

final class ConsultaPixRequest
{
    public function __construct(
        public readonly DateTimeInterface $inicio,
        public readonly DateTimeInterface $fim,
        public readonly ?string $txid = null,
        public readonly ?string $cpf = null,
        public readonly ?string $cnpj = null,
    )
    {}
}
