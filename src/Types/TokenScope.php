<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Types;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
enum TokenScope: string
{
    case COBRANCA_BOLETOS_CONSULTAR = 'cobranca_boletos_consultar';
    case COBRANCA_BOLETOS_INCLUIR = 'cobranca_boletos_incluir';
    case COBRANCA_BOLETOS_PAGADOR = 'cobranca_boletos_pagador';
    case COBRANCA_BOLETOS_SEGUNDA_VIA = 'cobranca_boletos_segunda_via';
    case COBRANCA_BOLETOS_DESCONTOS = 'cobranca_boletos_descontos';
    case COBRANCA_BOLETOS_ABATIMENTOS = 'cobranca_boletos_abatimentos';
    case COBRANCA_BOLETOS_VALOR_NOMINAL = 'cobranca_boletos_valor_nominal';
    case COBRANCA_BOLETOS_SEU_NUMERO = 'cobranca_boletos_seu_numero';
    case COBRANCA_BOLETOS_ESPECIE_DOCUMENTO = 'cobranca_boletos_especie_documento';
    case COBRANCA_BOLETOS_BAIXA = 'cobranca_boletos_baixa';
    case COBRANCA_BOLETOS_RATEIO_CREDITO = 'cobranca_boletos_rateio_credito';
    case COBRANCA_PAGADORES = 'cobranca_pagadores';
    case COBRANCA_BOLETOS_NEGATIVACOES_INCLUIR = 'cobranca_boletos_negativacoes_incluir';
    case COBRANCA_BOLETOS_NEGATIVACOES_ALTERAR = 'cobranca_boletos_negativacoes_alterar';
    case COBRANCA_BOLETOS_NEGATIVACOES_BAIXAR = 'cobranca_boletos_negativacoes_baixar';
    case COBRANCA_BOLETOS_PROTESTOS_INCLUIR = 'cobranca_boletos_protestos_incluir';
    case COBRANCA_BOLETOS_PROTESTOS_ALTERAR = 'cobranca_boletos_protestos_alterar';
    case COBRANCA_BOLETOS_PROTESTOS_DESISTIR = 'cobranca_boletos_protestos_desistir';
    case COBRANCA_BOLETOS_SOLICITACAO_MOVIMENTACAO_INCLUIR = 'cobranca_boletos_solicitacao_movimentacao_incluir';
    case COBRANCA_BOLETOS_SOLICITACAO_MOVIMENTACAO_CONSULTAR = 'cobranca_boletos_solicitacao_movimentacao_consultar';
    case COBRANCA_BOLETOS_SOLICITACAO_MOVIMENTACAO_DOWNLOAD = 'cobranca_boletos_solicitacao_movimentacao_download';
    case COBRANCA_BOLETOS_PRORROGACOES_DATA_VENCIMENTO = 'cobranca_boletos_prorrogacoes_data_vencimento';
    case COBRANCA_BOLETOS_PRORROGACOES_DATA_LIMITE_PAGAMENTO = 'cobranca_boletos_prorrogacoes_data_limite_pagamento';
    case COBRANCA_BOLETOS_ENCARGOS_MULTAS = 'cobranca_boletos_encargos_multas';
    case COBRANCA_BOLETOS_ENCARGOS_JUROS_MORA = 'cobranca_boletos_encargos_juros_mora';

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
