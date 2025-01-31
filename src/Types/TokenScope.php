<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Types;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
enum TokenScope: string
{
    case COBRANCA_BOLETOS_INCLUIR = 'boletos_inclusao';
    case COBRANCA_BOLETOS_CONSULTAR = 'boletos_consulta';
    case COBRANCA_BOLETOS_ALTERAR = 'boletos_alteracao';
    case COBRANCA_BOLETOS_WEBHOOKS_INCLUIR = 'webhooks_inclusao';
    case COBRANCA_BOLETOS_WEBHOOKS_CONSULTAR = 'webhooks_consulta';
    case COBRANCA_BOLETOS_WEBHOOKS_ALTERAR = 'webhooks_alteracao';

    /** Permissão para alteração de cobranças imediatas */
    case PIX_COB_WRITE = 'cob.write';
    /** Permissão para consulta de cobranças imediatas */
    case PIX_COB_READ = 'cob.read';
    /** Permissão para alteração de cobranças com vencimento */
    case PIX_COBV_WRITE = 'cobv.write';
    /** Permissão para consulta de cobranças com vencimento */
    case PIX_COBV_READ = 'cobv.read';
    /** Permissão para alteração de lotes de cobranças com vencimento */
    case PIX_LOTECOBV_WRITE = 'lotecobv.write';
    /** Permissão para consulta de lotes de cobranças com vencimento */
    case PIX_LOTECOBV_READ = 'lotecobv.read';
    /** Permissão para alteração de Pix */
    case PIX_WRITE = 'pix.write';
    /** Permissão para consulta de Pix */
    case PIX_READ = 'pix.read';
    /** Permissão para consulta do webhook */
    case PIX_WEBHOOK_READ = 'webhook.read';
    /** Permissão para alteração do webhook */
    case PIX_WEBHOOK_WRITE = 'webhook.write';
    /** Permissão para alteração de payloads */
    case PIX_PAYLOADLOCATION_WRITE = 'payloadlocation.write';
    /** Permissão para consulta de payloads */
    case PIX_PAYLOADLOCATION_READ = 'payloadlocation.read';

    case CONTA_CORRENTE_EXTRATO = 'cco_extrato';
    case CONTA_CORRENTE_SALDO = 'cco_saldo';
}
