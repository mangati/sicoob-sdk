<?php

namespace Mangati\Sicoob\Model\Boleto;


final class MensagensInstrucao
{
	/** @var string[]|null */
	private ?array $mensagens;

	/**
	 * @return string[]|null
	 */
	public function getMensagens(): ?array
	{
		return $this->mensagens;
	}

	/**
	 * @param string[]|null $mensagens
	 */
	public function setMensagens(?array $mensagens): self
	{
		$this->mensagens = $mensagens;
		return $this;
	}
}
