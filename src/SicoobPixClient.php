<?php

declare(strict_types=1);

namespace Mangati\Sicoob;

use Mangati\Sicoob\Dto\AuthenticationToken;
use Mangati\Sicoob\Dto\Pix\ConsultaPixRequest;
use Mangati\Sicoob\Dto\Pix\ConsultaPixResponse;
use Mangati\Sicoob\Dto\Pix\NovaCobrancaVencimentoRequest;
use Mangati\Sicoob\Dto\Pix\NovaCobrancaVencimentoResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Sicoob Pix specific client.
 *
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
final class SicoobPixClient extends SicoobClientBase
{
    private const PROD_API_URL = 'https://api.sicoob.com.br/pix/api/v2';
    private const SANDBOX_API_URL = 'https://sandbox.sicoob.com.br/sicoob/sandbox/pix/api/v2';

    public function __construct(HttpClientInterface $client)
    {
        parent::__construct(
            $client,
            self::PROD_API_URL,
            self::SANDBOX_API_URL,
        );
    }

    public function consultaPix(AuthenticationToken $token, ConsultaPixRequest $request): ConsultaPixResponse
    {
        return $this->authenticatedRequest(
            method: 'GET',
            path: '/pix',
            token: $token,
            requestData: $request,
            expectedStatusCode: 200,
            responseType: ConsultaPixResponse::class
        );
    }

    public function novaCobrancaVencimento(
        AuthenticationToken $token,
        string $txid,
        NovaCobrancaVencimentoRequest $request
    ): NovaCobrancaVencimentoResponse {
        return $this->authenticatedRequest(
            method: 'PUT',
            path: sprintf('/cobv/%s', $txid),
            token: $token,
            requestData: $request,
            expectedStatusCode: 201,
            responseType: NovaCobrancaVencimentoResponse::class
        );
    }
}
