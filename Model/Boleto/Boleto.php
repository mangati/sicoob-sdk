<?php

namespace Mangati\Sicoob\Model\Boleto;
use DateTimeInterface;

final class Boleto
{
	private ?int $numeroContrato = null;
	private ?int $modalidade = null;
	private ?int $numeroContaCorrente = null;
	private ?string $especieDocumento = null;
	private ?DateTimeInterface $dataEmissao = null;
	private ?string $seuNumero = null;
	private ?int $identificacaoEmissaoBoleto = null;
	private ?int $identificacaoDistribuicaoBoleto = null;
	private ?float $valor = null;
	private ?DateTimeInterface $dataVencimento = null;
	private ?DateTimeInterface $dataMulta = null;
	private ?DateTimeInterface $dataJurosMora = null;
	private ?int $tipoDesconto = null;
	private ?int $tipoMulta = null;
	private ?float $valorMulta = null;
	private ?int $tipoJurosMora = null;
	private ?float $valorJurosMora = null;
	private ?int $numeroParcela = null;
	private ?Pagador $pagador = null;
    private ?MensagensInstrucao $mensagensInstrucao = null;
	private ?bool $gerarPdf = null;
    private ?string $codigoBarras = null;
	private ?string $linhaDigitavel = null;
	private ?float $valorAbatimento = null;
	private ?float $valorPrimeiroDesconto = null;
	private ?float $valorSegundoDesconto = null;
	private ?float $valorTerceiroDesconto = null;
	private ?bool $aceite = null;
	private ?int $quantidadeDiasFloat = null;
	private ?int $codigoProtesto = null;
	private ?int $codigoNegativacao = null;
	private ?string $pdfBoleto = null;
	private ?int $nossoNumero = null;

	public function getNumeroContrato(): ?int
	{
		return $this->numeroContrato;
	}

	public function getModalidade(): ?int
	{
		return $this->modalidade;
	}

	public function getNumeroContaCorrente(): ?int
	{
		return $this->numeroContaCorrente;
	}

	public function getEspecieDocumento(): ?string
	{
		return $this->especieDocumento;
	}

	public function getDataEmissao(): ?DateTimeInterface
	{
		return $this->dataEmissao;
	}

	public function getSeuNumero(): ?string
	{
		return $this->seuNumero;
	}

	public function getIdentificacaoEmissaoBoleto(): ?int
	{
		return $this->identificacaoEmissaoBoleto;
	}

	public function getIdentificacaoDistribuicaoBoleto(): ?int
	{
		return $this->identificacaoDistribuicaoBoleto;
	}

	public function getValor(): ?float
	{
		return $this->valor;
	}

	public function getDataVencimento(): ?DateTimeInterface
	{
		return $this->dataVencimento;
	}

	public function getDataMulta(): ?DateTimeInterface
	{
		return $this->dataMulta;
	}

	public function getDataJurosMora(): ?DateTimeInterface
	{
		return $this->dataJurosMora;
	}

	public function getTipoDesconto(): ?int
	{
		return $this->tipoDesconto;
	}

	public function getTipoMulta(): ?int
	{
		return $this->tipoMulta;
	}

	public function getValorMulta(): ?float
	{
		return $this->valorMulta;
	}

	public function getTipoJurosMora(): ?int
	{
		return $this->tipoJurosMora;
	}

	public function getValorJurosMora(): ?float
	{
		return $this->valorJurosMora;
	}

	public function getNumeroParcela(): ?int
	{
		return $this->numeroParcela;
	}

	public function getPagador(): ?Pagador
	{
		return $this->pagador;
	}

	public function getMensagensInstrucao(): ?MensagensInstrucao
	{
		return $this->mensagensInstrucao;
	}

	public function getGerarPdf(): ?bool
	{
		return $this->gerarPdf;
	}

	public function setNumeroContrato(?int $numeroContrato): self
	{
		$this->numeroContrato = $numeroContrato;
		return $this;
	}

	public function setModalidade(?int $modalidade): self
	{
		$this->modalidade = $modalidade;
		return $this;
	}

	public function setNumeroContaCorrente(?int $numeroContaCorrente): self
	{
		$this->numeroContaCorrente = $numeroContaCorrente;
		return $this;
	}

	public function setEspecieDocumento(?string $especieDocumento): self
	{
		$this->especieDocumento = $especieDocumento;
		return $this;
	}

	public function setDataEmissao(?DateTimeInterface $dataEmissao): self
	{
		$this->dataEmissao = $dataEmissao;
		return $this;
	}

	public function setSeuNumero(?string $seuNumero): self
	{
		$this->seuNumero = $seuNumero;
		return $this;
	}

	public function setIdentificacaoEmissaoBoleto(?int $identificacaoEmissaoBoleto): self
	{
		$this->identificacaoEmissaoBoleto = $identificacaoEmissaoBoleto;
		return $this;
	}

	public function setIdentificacaoDistribuicaoBoleto(?int $identificacaoDistribuicaoBoleto): self
	{
		$this->identificacaoDistribuicaoBoleto = $identificacaoDistribuicaoBoleto;
		return $this;
	}

	public function setValor(?float $valor): self
	{
		$this->valor = $valor;
		return $this;
	}

	public function setDataVencimento(?DateTimeInterface $dataVencimento): self
	{
		$this->dataVencimento = $dataVencimento;
		return $this;
	}

	public function setDataMulta(?DateTimeInterface $dataMulta): self
	{
		$this->dataMulta = $dataMulta;
		return $this;
	}

	public function setDataJurosMora(?DateTimeInterface $dataJurosMora): self
	{
		$this->dataJurosMora = $dataJurosMora;
		return $this;
	}

	public function setTipoDesconto(?int $tipoDesconto): self
	{
		$this->tipoDesconto = $tipoDesconto;
		return $this;
	}

	public function setTipoMulta(?int $tipoMulta): self
	{
		$this->tipoMulta = $tipoMulta;
		return $this;
	}

	public function setValorMulta(?float $valorMulta): self
	{
		$this->valorMulta = $valorMulta;
		return $this;
	}

	public function setTipoJurosMora(?int $tipoJurosMora): self
	{
		$this->tipoJurosMora = $tipoJurosMora;
		return $this;
	}

	public function setValorJurosMora(?float $valorJurosMora): self
	{
		$this->valorJurosMora = $valorJurosMora;
		return $this;
	}

	public function setNumeroParcela(?int $numeroParcela): self
	{
		$this->numeroParcela = $numeroParcela;
		return $this;
	}

	public function setPagador(Pagador $pagador): self
	{
		$this->pagador = $pagador;
		return $this;
	}

	public function setMensagensInstrucao(?MensagensInstrucao $mensagensInstrucao): self
	{
		$this->mensagensInstrucao = $mensagensInstrucao;
		return $this;
	}

	public function setGerarPdf(?bool $gerarPdf): self
	{
		$this->gerarPdf = $gerarPdf;
		return $this;
	}

	public function getCodigoBarras(): ?string
	{
		return $this->codigoBarras;
	}

	public function getLinhaDigitavel(): ?string
	{
		return $this->linhaDigitavel;
	}

	public function getValorAbatimento(): ?float
	{
		return $this->valorAbatimento;
	}

	public function getValorPrimeiroDesconto(): ?float
	{
		return $this->valorPrimeiroDesconto;
	}

	public function getValorSegundoDesconto(): ?float
	{
		return $this->valorSegundoDesconto;
	}

	public function getValorTerceiroDesconto(): ?float
	{
		return $this->valorTerceiroDesconto;
	}

	public function getAceite(): ?bool
	{
		return $this->aceite;
	}

	public function getQuantidadeDiasFloat(): ?int
	{
		return $this->quantidadeDiasFloat;
	}

	public function getCodigoProtesto(): ?int
	{
		return $this->codigoProtesto;
	}

	public function getCodigoNegativacao(): ?int
	{
		return $this->codigoNegativacao;
	}

	public function getPdfBoleto(): ?string
	{
		return $this->pdfBoleto;
	}

	public function getNossoNumero(): ?int
	{
		return $this->nossoNumero;
	}

	public function setCodigoBarras(?string $codigoBarras): self
	{
		$this->codigoBarras = $codigoBarras;
		return $this;
	}

	public function setLinhaDigitavel(?string $linhaDigitavel): self
	{
		$this->linhaDigitavel = $linhaDigitavel;
		return $this;
	}

	public function setValorAbatimento(?float $valorAbatimento): self
	{
		$this->valorAbatimento = $valorAbatimento;
		return $this;
	}

	public function setValorPrimeiroDesconto(?float $valorPrimeiroDesconto): self
	{
		$this->valorPrimeiroDesconto = $valorPrimeiroDesconto;
		return $this;
	}

	public function setValorSegundoDesconto(?float $valorSegundoDesconto): self
	{
		$this->valorSegundoDesconto = $valorSegundoDesconto;
		return $this;
	}

	public function setValorTerceiroDesconto(?float $valorTerceiroDesconto): self
	{
		$this->valorTerceiroDesconto = $valorTerceiroDesconto;
		return $this;
	}

	public function setAceite(?bool $aceite): self
	{
		$this->aceite = $aceite;
		return $this;
	}

	public function setQuantidadeDiasFloat(?int $quantidadeDiasFloat): self
	{
		$this->quantidadeDiasFloat = $quantidadeDiasFloat;
		return $this;
	}

	public function setCodigoProtesto(?int $codigoProtesto): self
	{
		$this->codigoProtesto = $codigoProtesto;
		return $this;
	}

	public function setCodigoNegativacao(?int $codigoNegativacao): self
	{
		$this->codigoNegativacao = $codigoNegativacao;
		return $this;
	}

	public function setPdfBoleto(?string $pdfBoleto): self
	{
		$this->pdfBoleto = $pdfBoleto;
		return $this;
	}

	public function setNossoNumero(?int $nossoNumero): self
	{
		$this->nossoNumero = $nossoNumero;
		return $this;
	}
}
