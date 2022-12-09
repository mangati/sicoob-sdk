<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Model\CobrancaBancaria;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class MensagensInstrucao
{
    /** @param string[]|null $mensagens */
    public function __construct(
        public readonly ?array $mensagens = null,
    ) {
    }
}
