<?php

declare(strict_types=1);

namespace Mangati\Sicoob;

use Mangati\Sicoob\Dto\AuthenticationToken;
use Mangati\Sicoob\Dto\ContaCorrente\ConsultaExtratoRequest;
use Mangati\Sicoob\Dto\ContaCorrente\ConsultaExtratoResponse;
use Mangati\Sicoob\Dto\ContaCorrente\ConsultaSaldoRequest;
use Mangati\Sicoob\Dto\ContaCorrente\ConsultaSaldoResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Sicoob Conta Corrente specific client.
 *
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class SicoobContaCorrenteClient extends SicoobClientBase
{
    private const PROD_API_URL = 'https://api.sicoob.com.br/conta-corrente';
    private const SANDBOX_API_URL = 'https://sandbox.sicoob.com.br/sicoob/sandbox/conta-corrente';

    public function __construct(HttpClientInterface $client)
    {
        parent::__construct(
            $client,
            self::PROD_API_URL,
            self::SANDBOX_API_URL,
        );
    }

    public function consultaExtrato(
        AuthenticationToken $token,
        ConsultaExtratoRequest $request
    ): ConsultaExtratoResponse {
        return $this->authenticatedRequest(
            method: 'GET',
            path: sprintf('/v3/extrato/%s/%s', $request->mes, $request->ano),
            token: $token,
            requestData: [
                'numeroContaCorrente' => $request->numeroContaCorrente,
                'diaInicial' => $request->diaInicial,
                'diaFinal' => $request->diaFinal,
            ],
            expectedStatusCode: 200,
            responseType: ConsultaExtratoResponse::class
        );
    }

    public function consultaSaldo(
        AuthenticationToken $token,
        ConsultaSaldoRequest $request
    ): ConsultaSaldoResponse {
        return $this->authenticatedRequest(
            method: 'GET',
            path: '/v2/saldo',
            token: $token,
            requestData: [
                'numeroContaCorrente' => $request->numeroContaCorrente,
            ],
            expectedStatusCode: 200,
            responseType: ConsultaSaldoResponse::class
        );
    }
}
