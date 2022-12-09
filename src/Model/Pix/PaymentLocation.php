<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Model\Pix;

use DateTimeInterface;
use Mangati\Sicoob\Types\Pix\TipoCob;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class PaymentLocation
{
    public function __construct(
        public readonly int $id,
        public readonly string $location,
        public readonly TipoCob $tipoCob,
        public readonly DateTimeInterface $criacao,
        public readonly string $txid,
        public readonly string $brcode,
    ) {
    }
}
