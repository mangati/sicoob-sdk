<?php

namespace Mangati\Sicoob\Model\Boleto;

final class Pagador
{
	private string $numeroCpfCnpj;
	private string $nome;
	private string $endereco;
	private string $bairro;
	private string $cidade;
	private string $cep;
	private string $uf;
	/** @var string[] */
	private array $email;

	public function getNumeroCpfCnpj(): string
	{
		return $this->numeroCpfCnpj;
	}

	public function getNome(): string
	{
		return $this->nome;
	}

	public function getEndereco(): string
	{
		return $this->endereco;
	}

	public function getBairro(): string
	{
		return $this->bairro;
	}

	public function getCidade(): string
	{
		return $this->cidade;
	}

	public function getCep(): string
	{
		return $this->cep;
	}

	public function getUf(): string
	{
		return $this->uf;
	}

	/**
	 * @return string[]
	 */
	public function getEmail(): array
	{
		return $this->email;
	}

	public function setNumeroCpfCnpj(string $numeroCpfCnpj): self
	{
		$this->numeroCpfCnpj = $numeroCpfCnpj;
		return $this;
	}

	public function setNome(string $nome): self
	{
		$this->nome = $nome;
		return $this;
	}

	public function setEndereco(string $endereco): self
	{
		$this->endereco = $endereco;
		return $this;
	}

	public function setBairro(string $bairro): self
	{
		$this->bairro = $bairro;
		return $this;
	}

	public function setCidade(string $cidade): self
	{
		$this->cidade = $cidade;
		return $this;
	}

	public function setCep(string $cep): self
	{
		$this->cep = $cep;
		return $this;
	}

	public function setUf(string $uf): self
	{
		$this->uf = $uf;
		return $this;
	}

	/**
	 * @param string[] $email
	 */
	public function setEmail(array $email): self
	{
		$this->email = $email;
		return $this;
	}
}
