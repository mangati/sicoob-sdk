<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Model\Pix;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class CalendarioSimples
{
    public function __construct(
        public readonly int $expiracao,
    ) {
    }
}
