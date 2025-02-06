<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Model\CobrancaBancaria;

use DateTimeInterface;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
class Movimentacao
{
    public function __construct(
        public readonly string $siglaMovimento,
        public readonly DateTimeInterface $dataInicioMovimento,
        public readonly DateTimeInterface $dataFimMovimento,
        public readonly int $numeroCliente,
        public readonly int $numeroContrato,
        public readonly int $modalidade,
        public readonly int $numeroTitulo,
        public readonly string $seuNumero,
        public readonly DateTimeInterface $dataVencimentoTitulo,
        public readonly float $valorTitulo,
        public readonly string $codigoBarras,
        public readonly DateTimeInterface $dataMovimentoEntrada,
        public readonly DateTimeInterface $dataEmissaoDocumento,
        public readonly DateTimeInterface $dataLimitePagamento,
        public readonly int $numeroContaCorrente,
        public readonly float $valorTarifaMovimento,
        public readonly int $numeroContratoCobranca,
    ) {
    }
}
