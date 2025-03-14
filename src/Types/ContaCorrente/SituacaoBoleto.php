<?php

namespace Mangati\Sicoob\Types\ContaCorrente;

enum SituacaoBoleto : string
{
    case EM_ABERTO = 'Em Aberto';
    case BAIXADO = 'Baixado';
    case LIQUIDADO = 'Liquidado';
}
