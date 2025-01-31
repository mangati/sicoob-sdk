<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Tests;

use Mangati\Sicoob\Dto\TokenRequest;
use Mangati\Sicoob\SicoobPixClient;
use Mangati\Sicoob\Types\TokenScope;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
class SicoobAuthenticationTest extends TestCase
{
    private const CLIENT_ID = 'testClientId';

    public function testAuthentication(): void
    {
        $client = new MockHttpClient([
            function ($method, $url, $options): MockResponse {
                $expectedUrl = 'https://auth.sicoob.com.br/auth/realms/cooperado/protocol/openid-connect/token';
                $expectedBody = 'grant_type=client_credentials&' .
                    'client_id=testClientId&' .
                    'scope=boletos_inclusao+cob.read+cco_extrato';

                $this->assertSame('POST', $method);
                $this->assertSame($expectedUrl, $url);
                $this->assertSame($expectedBody, $options['body']);

                return new MockResponse(
                    TestUtils::readResource('token-response.json'),
                );
            },
        ]);

        $sicoob = new SicoobPixClient($client);

        $response = $sicoob->token(new TokenRequest(
            clientId: self::CLIENT_ID,
            scopes: [
                TokenScope::COBRANCA_BOLETOS_INCLUIR,
                TokenScope::PIX_COB_READ,
                TokenScope::CONTA_CORRENTE_EXTRATO,
            ],
        ));

        $this->assertNotNull($response->token);
        $this->assertEquals('testToken', $response->token->accessToken);
        $this->assertEquals(300, $response->token->expiresIn);
        $this->assertEquals(0, $response->token->refreshExpiresIn);
        $this->assertEquals('Bearer', $response->token->tokenType);
        $this->assertContains(TokenScope::COBRANCA_BOLETOS_INCLUIR, $response->token->scopes);
    }
}
