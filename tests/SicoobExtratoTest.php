<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Tests;

use DateTimeInterface;
use Mangati\Sicoob\Dto\AuthenticationToken;
use Mangati\Sicoob\Dto\ContaCorrente\ConsultaExtratoRequest;
use Mangati\Sicoob\Model\ContaCorrente\Extrato;
use Mangati\Sicoob\SicoobContaCorrenteClient;
use Mangati\Sicoob\Types\ContaCorrente\TipoTransacao;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
class SicoobExtratoTest extends TestCase
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
                $expectedUrl = 'https://api.sicoob.com.br/conta-corrente/v3/extrato/10/2023?numeroContaCorrente=123456';

                $this->assertSame('GET', $method);
                $this->assertSame($expectedUrl, $url);
                $this->assertContains(sprintf('Authorization: Bearer %s', self::ACCESS_TOKEN), $options['headers']);
                $this->assertContains(sprintf('client_id: %s', self::CLIENT_ID), $options['headers']);

                return new MockResponse(
                    TestUtils::readResource('consulta-extrato-response.json'),
                    [ 'http_code' => 200 ]
                );
            },
        ]);

        $sicoob = new SicoobContaCorrenteClient($client);

        $response = $sicoob->consultaExtrato($token, new ConsultaExtratoRequest(
            mes: 10,
            ano: 2023,
            numeroContaCorrente: 123456,
        ));

        $this->assertEmpty($response->mensagens);
        $this->assertInstanceOf(Extrato::class, $response->resultado);
        $this->assertCount(5, $response->resultado->transacoes);
        $this->assertInstanceOf(TipoTransacao::class, $response->resultado->transacoes[0]->tipo);
        $this->assertInstanceOf(DateTimeInterface::class, $response->resultado->transacoes[0]->data);
    }

    public function testConsultaExtratoSandboxUrl(): void
    {
        $client = new MockHttpClient([
            function ($method, $url, $options): MockResponse {
                $expectedUrl = 'https://sandbox.sicoob.com.br/sicoob/sandbox/conta-corrente/v3/extrato/10/2023'
                    . '?numeroContaCorrente=123456';

                $this->assertSame('GET', $method);
                $this->assertSame($expectedUrl, $url);
                $this->assertContains(sprintf('Authorization: Bearer %s', self::ACCESS_TOKEN), $options['headers']);
                $this->assertContains(sprintf('client_id: %s', self::CLIENT_ID), $options['headers']);

                return new MockResponse(
                    TestUtils::readResource('consulta-extrato-response.json'),
                    [ 'http_code' => 200 ]
                );
            },
        ]);

        $token = SicoobContaCorrenteClient::sandboxToken(self::CLIENT_ID, self::ACCESS_TOKEN);
        $sicoob = new SicoobContaCorrenteClient($client);

        $sicoob->consultaExtrato($token, new ConsultaExtratoRequest(
            mes: 10,
            ano: 2023,
            numeroContaCorrente: 123456,
        ));
    }
}
