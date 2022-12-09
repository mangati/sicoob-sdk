<?php

namespace Mangati\Sicoob\Model\Pix;

use DateTimeInterface;

final class Pix
{
    public function __construct(
        public readonly string $endToEndId,
        public readonly string $valor,
        public readonly DateTimeInterface $horario,
        public readonly string $nomePagador,
        public readonly string $infoPagador,
        public readonly Pessoa $pagador,
    )
    {}
}
