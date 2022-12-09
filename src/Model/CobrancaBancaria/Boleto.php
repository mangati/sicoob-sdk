<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Model\CobrancaBancaria;

use DateTimeInterface;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class Boleto
{
    public function __construct(
        public readonly ?int $numeroContrato = null,
        public readonly ?int $modalidade = null,
        public readonly ?int $numeroContaCorrente = null,
        public readonly ?string $especieDocumento = null,
        public readonly ?DateTimeInterface $dataEmissao = null,
        public readonly ?string $seuNumero = null,
        public readonly ?int $identificacaoEmissaoBoleto = null,
        public readonly ?int $identificacaoDistribuicaoBoleto = null,
        public readonly ?float $valor = null,
        public readonly ?DateTimeInterface $dataVencimento = null,
        public readonly ?DateTimeInterface $dataMulta = null,
        public readonly ?DateTimeInterface $dataJurosMora = null,
        public readonly ?int $tipoDesconto = null,
        public readonly ?int $tipoMulta = null,
        public readonly ?float $valorMulta = null,
        public readonly ?int $tipoJurosMora = null,
        public readonly ?float $valorJurosMora = null,
        public readonly ?int $numeroParcela = null,
        public readonly ?Pagador $pagador = null,
        public readonly ?MensagensInstrucao $mensagensInstrucao = null,
        public readonly ?bool $gerarPdf = null,
        public readonly ?string $codigoBarras = null,
        public readonly ?string $linhaDigitavel = null,
        public readonly ?float $valorAbatimento = null,
        public readonly ?float $valorPrimeiroDesconto = null,
        public readonly ?DateTimeInterface $dataPrimeiroDesconto = null,
        public readonly ?float $valorSegundoDesconto = null,
        public readonly ?DateTimeInterface $dataSegundoDesconto = null,
        public readonly ?float $valorTerceiroDesconto = null,
        public readonly ?DateTimeInterface $dataTerceiroDesconto = null,
        public readonly ?bool $aceite = null,
        public readonly ?int $quantidadeDiasFloat = null,
        public readonly ?int $codigoProtesto = null,
        public readonly ?int $codigoNegativacao = null,
        public readonly ?string $pdfBoleto = null,
        public readonly ?int $nossoNumero = null,
    ) {
    }
}
