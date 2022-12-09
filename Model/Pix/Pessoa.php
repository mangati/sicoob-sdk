<?php

namespace Mangati\Sicoob\Model\Pix;


final class Pessoa
{
    public function __construct(
        public readonly string $nome,
        public readonly ?string $cpf = null,
        public readonly ?string $cnpj = null,
        public readonly ?string $logradouro = null,
        public readonly ?string $cidade = null,
        public readonly ?string $uf = null,
        public readonly ?string $cep = null,
    )
    {}
}
