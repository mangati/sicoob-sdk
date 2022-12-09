<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Model\Pix;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
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
    ) {
    }
}
