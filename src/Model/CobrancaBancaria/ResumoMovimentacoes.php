<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Model\CobrancaBancaria;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
class ResumoMovimentacoes
{
    /** @param int[] $idArquivos */
    public function __construct(
        public readonly int $quantidadeTotalRegistros,
        public readonly int $quantidadeArquivo,
        public readonly array $idArquivos,
    ) {
    }
}
