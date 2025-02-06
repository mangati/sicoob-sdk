<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Model\CobrancaBancaria;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
class MovimentacaoDownload
{
    public function __construct(
        public readonly string $arquivo,
        public readonly string $nomeArquivo,
    ) {
    }
}
