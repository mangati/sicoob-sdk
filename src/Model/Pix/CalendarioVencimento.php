<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Model\Pix;

use DateTimeInterface;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class CalendarioVencimento
{
    public function __construct(
        #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
        public readonly DateTimeInterface $dataDeVencimento,
        public readonly int $validadeAposVencimento,
    ) {
    }
}
