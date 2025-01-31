<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Model\CobrancaBancaria;

use DateTimeInterface;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class HistoricoBoleto
{
    public function __construct(
        #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
        public readonly ?DateTimeInterface $dataHistorico = null,
        public readonly ?int $tipoHistorico = null,
        public readonly ?string $descricaoHistorico = null,
    ) {
    }
}
