<?php

declare(strict_types=1);

namespace Mangati\Sicoob;

use Mangati\Sicoob\Dto\AuthenticationToken;
use Mangati\Sicoob\Dto\TokenRequest;
use Mangati\Sicoob\Dto\TokenResponse;
use Mangati\Sicoob\Exception\SicoobException;
use Mangati\Sicoob\Types\TokenScope;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 *
 * @internal
 */
abstract class SicoobClientBase
{
    private const TOKEN_API_URL = 'https://auth.sicoob.com.br/auth/realms/cooperado/protocol/openid-connect/token';
    private const OAUTH_GRANT_TYPE = 'client_credentials';

    private readonly SerializerInterface $serializer;
    private readonly NormalizerInterface $normalizer;

    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly string $prodUrl,
        private readonly string $sandboxUrl,
    ) {
        $this->serializer = SerializerFactory::createSerializer();
        $this->normalizer = SerializerFactory::createNormalizer();
    }

    /**
     * Returns a sandbox token.
     *
     * @see https://developers.sicoob.com.br/portal/sandbox
     */
    public static function sandboxToken(string $clientId, string $accessToken): AuthenticationToken
    {
        return new AuthenticationToken(
            isSandbox: true,
            clientId: $clientId,
            accessToken: $accessToken,
            tokenType: 'Bearer',
            expiresIn: 0,
            refreshExpiresIn: 0,
            scopes: [],
        );
    }

    public function token(TokenRequest $request): TokenResponse
    {
        $scopes = array_map(fn (TokenScope $ts) => $ts->value, $request->scopes);
        $response = $this->request(
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

    /**
     * @template T of mixed
     * @param class-string<T> $responseType
     * @return T
     */
    protected function authenticatedRequest(
        string $path,
        string $method,
        AuthenticationToken $token,
        mixed $requestData,
        int $expectedStatusCode,
        string $responseType
    ): mixed {
        $options = [
            'headers' => [
                'Content-type' => 'application/json',
                'client_id' => $token->clientId,
                'Authorization' => "Bearer {$token->accessToken}",
            ],
        ];
        if ('GET' === strtoupper($method)) {
            $options['query'] = $this->toArray($requestData);
        } else {
            $options['body'] = $this->toJson($requestData);
        }

        $data = $this->request(
            method: $method,
            url: $this->url($token, $path),
            options: $options,
            expectedStatusCode: $expectedStatusCode,
        );

        $response = $this
            ->serializer
            ->deserialize($data->getContent(), $responseType, 'json');

        return $response;
    }

    /**
     * @param array<mixed> $options
     */
    private function request(
        string $method,
        string $url,
        array $options,
        int $expectedStatusCode
    ): ResponseInterface {
        $response = $this->client->request($method, $url, $options);
        $statusCode = $response->getStatusCode();
        if ($expectedStatusCode !== $statusCode) {
            throw new SicoobException(
                url: $url,
                statusCode: $statusCode,
                body: $response->getContent(false),
            );
        }

        return $response;
    }

    private function url(AuthenticationToken $token, string $path): string
    {
        if ($token->isSandbox) {
            return $this->sandboxUrl . $path;
        }

        return $this->prodUrl . $path;
    }

    private function toJson(mixed $data): string
    {
        return $this->serializer->serialize(
            $data,
            'json',
            [AbstractObjectNormalizer::SKIP_NULL_VALUES => true],
        );
    }

    /** @return array<mixed> */
    private function toArray(mixed $data): array
    {
        if (is_array($data)) {
            return $data;
        }
        return $this->normalizer->normalize(
            $data,
            'array',
            [AbstractObjectNormalizer::SKIP_NULL_VALUES => true],
        );
    }
}
