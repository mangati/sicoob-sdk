<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Dto\CobrancaBancaria;

use Mangati\Sicoob\Model\CobrancaBancaria\MovimentacaoDownload;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class DownloadMovimentacoesResponse
{
    public function __construct(
        public readonly MovimentacaoDownload $resultado,
    ) {
    }
}
