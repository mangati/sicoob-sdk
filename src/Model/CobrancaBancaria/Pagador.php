<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Model\CobrancaBancaria;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class Pagador
{
    /** @param string[] $email */
    public function __construct(
        public readonly string $numeroCpfCnpj,
        public readonly string $nome,
        public readonly string $endereco,
        public readonly string $bairro,
        public readonly string $cidade,
        public readonly string $cep,
        public readonly string $uf,
        public readonly array $email,
    ) {
    }
}
