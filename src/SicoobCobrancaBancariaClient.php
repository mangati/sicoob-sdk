<?php

declare(strict_types=1);

namespace Mangati\Sicoob;

use Mangati\Sicoob\Dto\AuthenticationToken;
use Mangati\Sicoob\Dto\CobrancaBancaria\BaixarBoletoRequest;
use Mangati\Sicoob\Dto\CobrancaBancaria\BaixarBoletoResponse;
use Mangati\Sicoob\Dto\CobrancaBancaria\ConsultaBoletoRequest;
use Mangati\Sicoob\Dto\CobrancaBancaria\ConsultaBoletoResponse;
use Mangati\Sicoob\Dto\CobrancaBancaria\ProrrogarDatasVencimentoRequest;
use Mangati\Sicoob\Dto\CobrancaBancaria\ProrrogarDatasVencimentoResponse;
use Mangati\Sicoob\Dto\CobrancaBancaria\IncluirBoletoRequest;
use Mangati\Sicoob\Dto\CobrancaBancaria\SegundaViaBoletoRequest;
use Mangati\Sicoob\Dto\CobrancaBancaria\SegundaViaBoletoResponse;
use Mangati\Sicoob\Dto\CobrancaBancaria\IncluirBoletoResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Sicoob Cobrança Bancária specific client.
 *
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class SicoobCobrancaBancariaClient extends SicoobClientBase
{
    private const PROD_API_URL = 'https://api.sicoob.com.br/cobranca-bancaria/v3';
    private const SANDBOX_API_URL = 'https://sandbox.sicoob.com.br/sicoob/sandbox/cobranca-bancaria/v3';

    public function __construct(HttpClientInterface $client)
    {
        parent::__construct(
            $client,
            self::PROD_API_URL,
            self::SANDBOX_API_URL,
        );
    }

    public function incluirBoleto(
        AuthenticationToken $token,
        IncluirBoletoRequest $request
    ): IncluirBoletoResponse {
        return $this->authenticatedRequest(
            method: 'POST',
            path: '/boletos',
            token: $token,
            requestData: $request->boleto,
            expectedStatusCode: 200,
            responseType: IncluirBoletoResponse::class
        );
    }

    public function prorrogarDatasVencimento(
        AuthenticationToken $token,
        ProrrogarDatasVencimentoRequest $request
    ): ProrrogarDatasVencimentoResponse {
        return $this->authenticatedRequest(
            method: 'PATCH',
            path: '/boletos/prorrogacoes/data-vencimento',
            token: $token,
            requestData: $request->prorrogacoes,
            expectedStatusCode: 207,
            responseType: ProrrogarDatasVencimentoResponse::class
        );
    }

    public function segundaViaBoleto(
        AuthenticationToken $token,
        SegundaViaBoletoRequest $request
    ): SegundaViaBoletoResponse {
        return $this->authenticatedRequest(
            method: 'GET',
            path: '/boletos/segunda-via',
            token: $token,
            requestData: $request,
            expectedStatusCode: 207,
            responseType: SegundaViaBoletoResponse::class
        );
    }

    public function consultarBoleto(
        AuthenticationToken $token,
        ConsultaBoletoRequest $request
    ): ConsultaBoletoResponse {
        return $this->authenticatedRequest(
            method: 'GET',
            path: '/boletos',
            token: $token,
            requestData: $request,
            expectedStatusCode: 200,
            responseType: ConsultaBoletoResponse::class
        );
    }

    public function baixarBoleto(
        AuthenticationToken $token,
        BaixarBoletoRequest $request
    ): BaixarBoletoResponse {
        return $this->authenticatedRequest(
            method: 'POST',
            path: sprintf('/boletos/%s/baixar', $request->nossoNumero),
            token: $token,
            requestData: $request,
            expectedStatusCode: 204,
            responseType: BaixarBoletoResponse::class,
        );
    }
}
