<?php

namespace Mangati\Sicoob;

use Mangati\Sicoob\Dto\AuthenticationToken;
use Mangati\Sicoob\Dto\Pix\ConsultaPixRequest;
use Mangati\Sicoob\Dto\Pix\ConsultaPixResponse;
use Mangati\Sicoob\Dto\Pix\NovaCobrancaVencimentoRequest;
use Mangati\Sicoob\Dto\Pix\NovaCobrancaVencimentoResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class SicoobPixClient extends SicoobClientBase
{
    private const PIX_API_URL = 'https://api.sicoob.com.br/pix/api/v2';

    public function __construct(
        HttpClientInterface $client,
        SerializerInterface $serializer,
        NormalizerInterface $normalizer,
    )
    {
        parent::__construct($client, $serializer, $normalizer);
    }

    public function consultaPix(AuthenticationToken $token, ConsultaPixRequest $request): ConsultaPixResponse
    {
        return $this->doJsonRequest(
            method: 'GET',
            url: self::PIX_API_URL . '/pix',
            token: $token,
            requestData: $request,
            expectedStatusCode: 200,
            responseType: ConsultaPixResponse::class
        );
    }

    public function novaCobrancaVencimento(AuthenticationToken $token, string $txid, NovaCobrancaVencimentoRequest $request): NovaCobrancaVencimentoResponse
    {
        return $this->doJsonRequest(
            method: 'PUT',
            url: self::PIX_API_URL . '/cobv/' . $txid,
            token: $token,
            requestData: $request,
            expectedStatusCode: 201,
            responseType: NovaCobrancaVencimentoResponse::class
        );
    }
}
