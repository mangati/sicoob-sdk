<?php

namespace Mangati\Sicoob;

use Exception;
use Mangati\Sicoob\Dto\AuthenticationToken;
use Mangati\Sicoob\Dto\TokenRequest;
use Mangati\Sicoob\Dto\TokenResponse;
use Mangati\Sicoob\Types\TokenScope;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class SicoobClientBase
{
    private const TOKEN_API_URL = 'https://auth.sicoob.com.br/auth/realms/cooperado/protocol/openid-connect/token';
    private const OAUTH_GRANT_TYPE = 'client_credentials';

    public function __construct(
        private HttpClientInterface $client,
        private SerializerInterface $serializer,
        private NormalizerInterface $normalizer,
    )
    {}

    public function token(TokenRequest $request): TokenResponse
    {
        $scopes = array_map(fn (TokenScope $ts) => $ts->value, $request->scopes);
        $response = $this->doRequest(
            method: 'POST',
            url: self::TOKEN_API_URL,
            options: [
                'headers' => [
                    'Content-type' => 'application/x-www-form-urlencoded',
                ],
                'body' => [
                    'grant_type' => self::OAUTH_GRANT_TYPE,
                    'client_id' => $request->clientId,
                    'scope' => implode(' ', $scopes),
                ],
            ],
            expectedStatusCode: 200,
        );

        $data = $response->toArray(false);
        $scopes = explode(' ', $data['scope']);
        $token = new AuthenticationToken(
            clientId: $request->clientId,
            tokenType: $data['token_type'],
            accessToken: $data['access_token'],
            expiresIn: $data['expires_in'],
            refreshExpiresIn: $data['refresh_expires_in'],
            scopes: array_map(fn (string $s) => TokenScope::from($s), $scopes),
        );

        return new TokenResponse($token);
    }

    protected function doJsonRequest(
        string $url,
        string $method,
        AuthenticationToken $token,
        mixed $requestData,
        int $expectedStatusCode,
        string $responseType
    ) {
        $options = [
            'headers' => [
                'Content-type' => 'application/json',
                'client_id' => $token->clientId,
                'Authorization' => "Bearer {$token->accessToken}",
            ],
        ];
        if ('GET' === strtoupper($method)) {
            $options['query'] = $this->normalizer->normalize(
                $requestData,
                'array',
                [AbstractObjectNormalizer::SKIP_NULL_VALUES => true],
            );;
        } else {
            $options['body'] = $this->serializer->serialize(
                $requestData,
                'json',
                [AbstractObjectNormalizer::SKIP_NULL_VALUES => true],
            );
        }

        $data = $this->doRequest(
            method: $method,
            url: $url,
            options: $options,
            expectedStatusCode: $expectedStatusCode,
        );

        $response = $this
            ->serializer
            ->deserialize($data->getContent(), $responseType, 'json');

        return $response;
    }

    private function doRequest(
        string $method,
        string $url,
        array $options,
        int $expectedStatusCode
    ): ResponseInterface
    {
        $statusCode = null;
        $response = $this->client->request($method, $url, $options);

        try {
            $statusCode = $response->getStatusCode();
        } catch (TransportExceptionInterface $e) {
            throw new Exception('error: ' . $e->getMessage());
        }

        if ($expectedStatusCode !== $statusCode) {
            $body = $response->toArray(false);
            if (array_key_exists('error_desription', $body)) {
                throw new Exception($body['error_description']);
            }
            throw new Exception(json_encode($body));
        }

        return $response;
    }
}
