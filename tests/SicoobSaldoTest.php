<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Tests;

use Mangati\Sicoob\Dto\AuthenticationToken;
use Mangati\Sicoob\Dto\ContaCorrente\ConsultaSaldoRequest;
use Mangati\Sicoob\Model\ContaCorrente\Saldo;
use Mangati\Sicoob\SicoobContaCorrenteClient;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
class SicoobSaldoTest extends TestCase
{
    private const CLIENT_ID = 'testClientId';
    private const ACCESS_TOKEN = 'testAccessToken';

    public function testConsultaExtrato(): void
    {
        $token = new AuthenticationToken(
            clientId: self::CLIENT_ID,
            accessToken: self::ACCESS_TOKEN,
            tokenType: 'Bearer',
            expiresIn: 1,
            refreshExpiresIn: 1,
            scopes: [],
        );

        $client = new MockHttpClient([
            function ($method, $url, $options): MockResponse {
                $expectedUrl = 'https://api.sicoob.com.br/conta-corrente/v2/saldo?numeroContaCorrente=123456';

                $this->assertSame('GET', $method);
                $this->assertSame($expectedUrl, $url);
                $this->assertContains(sprintf('Authorization: Bearer %s', self::ACCESS_TOKEN), $options['headers']);
                $this->assertContains(sprintf('client_id: %s', self::CLIENT_ID), $options['headers']);

                return new MockResponse(
                    TestUtils::readResource('consulta-saldo-response.json'),
                    [ 'http_code' => 200 ]
                );
            },
        ]);

        $sicoob = new SicoobContaCorrenteClient($client);

        $response = $sicoob->consultaSaldo($token, new ConsultaSaldoRequest(
            numeroContaCorrente: 123456,
        ));

        $this->assertEmpty($response->mensagens);
        $this->assertInstanceOf(Saldo::class, $response->resultado);
        $this->assertSame('4302.49', $response->resultado->saldo);
        $this->assertSame('5000.00', $response->resultado->saldoLimite);
    }

    public function testConsultaExtratoSandboxUrl(): void
    {
        $client = new MockHttpClient([
            function ($method, $url, $options): MockResponse {
                $expectedUrl = 'https://sandbox.sicoob.com.br/sicoob/sandbox/conta-corrente/v2/saldo'
                    . '?numeroContaCorrente=123456';

                $this->assertSame('GET', $method);
                $this->assertSame($expectedUrl, $url);
                $this->assertContains(sprintf('Authorization: Bearer %s', self::ACCESS_TOKEN), $options['headers']);
                $this->assertContains(sprintf('client_id: %s', self::CLIENT_ID), $options['headers']);

                return new MockResponse(
                    TestUtils::readResource('consulta-saldo-response.json'),
                    [ 'http_code' => 200 ]
                );
            },
        ]);

        $token = SicoobContaCorrenteClient::sandboxToken(self::CLIENT_ID, self::ACCESS_TOKEN);
        $sicoob = new SicoobContaCorrenteClient($client);

        $sicoob->consultaSaldo($token, new ConsultaSaldoRequest(
            numeroContaCorrente: 123456,
        ));
    }
}
