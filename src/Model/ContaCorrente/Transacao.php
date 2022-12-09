<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Model\ContaCorrente;

use DateTimeInterface;
use Mangati\Sicoob\Types\ContaCorrente\TipoTransacao;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class Transacao
{
    public function __construct(
        public readonly TipoTransacao $tipo,
        public readonly string $valor,
        public readonly DateTimeInterface $data,
        public readonly DateTimeInterface $dataLote,
        public readonly string $descricao,
        public readonly string $numeroDocumento,
        public readonly ?string $descInfComplementar = null,
        public readonly ?string $cpfCnpj = null,
    ) {
    }
}
