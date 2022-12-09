<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Types\ContaCorrente;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
enum TipoTransacao: string
{
    case DEBITO = 'DEBITO';
    case CREDITO = 'CREDITO';
}
