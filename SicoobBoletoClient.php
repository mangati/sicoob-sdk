<?php

namespace Mangati\Sicoob;

use Mangati\Sicoob\Dto\AuthenticationToken;
use Mangati\Sicoob\Dto\Boleto\ProrrogarDatasVencimentoRequest;
use Mangati\Sicoob\Dto\Boleto\ProrrogarDatasVencimentoResponse;
use Mangati\Sicoob\Dto\Boleto\IncluirBoletosRequest;
use Mangati\Sicoob\Dto\Boleto\SegundaViaBoletoRequest;
use Mangati\Sicoob\Dto\Boleto\SegundaViaBoletoResponse;
use Mangati\Sicoob\Dto\Boleto\IncluirBoletosResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class SicoobBoletoClient extends SicoobClientBase
{
    private const BOLETOS_API_URL = 'https://api.sicoob.com.br/cobranca-bancaria/v2/boletos';

    public function __construct(
        HttpClientInterface $client,
        SerializerInterface $serializer,
        NormalizerInterface $normalizer,
    )
    {
        parent::__construct($client, $serializer, $normalizer);
    }

    public function incluirBoletos(AuthenticationToken $token, IncluirBoletosRequest $request): IncluirBoletosResponse
    {
        return $this->doJsonRequest(
            method: 'POST',
            url: self::BOLETOS_API_URL,
            token: $token,
            requestData: $request->boletos,
            expectedStatusCode: 207,
            responseType: IncluirBoletosResponse::class
        );
    }

    public function prorrogarDatasVencimento(AuthenticationToken $token, ProrrogarDatasVencimentoRequest $request): ProrrogarDatasVencimentoResponse
    {
        return $this->doJsonRequest(
            method: 'PATCH',
            url: self::BOLETOS_API_URL . '/prorrogacoes/data-vencimento',
            token: $token,
            requestData: $request->prorrogacoes,
            expectedStatusCode: 207,
            responseType: ProrrogarDatasVencimentoResponse::class
        );
    }

    public function segundaViaBoleto(AuthenticationToken $token, SegundaViaBoletoRequest $request): SegundaViaBoletoResponse
    {
        return $this->doJsonRequest(
            method: 'GET',
            url: self::BOLETOS_API_URL . '/segunda-via',
            token: $token,
            requestData: $request,
            expectedStatusCode: 207,
            responseType: ProrrogarDatasVencimentoResponse::class
        );
    }
}
