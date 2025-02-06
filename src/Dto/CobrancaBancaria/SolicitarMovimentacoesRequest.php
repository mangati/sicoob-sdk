<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Dto\CobrancaBancaria;

use DateTimeInterface;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class SolicitarMovimentacoesRequest
{
    public function __construct(
        public readonly int $numeroCliente,
        public readonly int $tipoMovimento,
        #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
        public readonly DateTimeInterface $dataInicial,
        #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
        public readonly DateTimeInterface $dataFinal,
    ) {
    }
}
