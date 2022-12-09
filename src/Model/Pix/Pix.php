<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Model\Pix;

use DateTimeInterface;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class Pix
{
    public function __construct(
        public readonly string $endToEndId,
        public readonly string $valor,
        public readonly DateTimeInterface $horario,
        public readonly string $nomePagador,
        public readonly string $infoPagador,
        public readonly Pessoa $pagador,
    ) {
    }
}
