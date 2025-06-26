<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Types\ContaCorrente;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
enum CodigoCadastroPix: int
{
    case PADRAO = 0;
    case COM_PIX = 1;
    case SEM_PIX = 2;
}
