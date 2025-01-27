<?php

declare(strict_types=1);

namespace Mangati\Sicoob\Tests;

use DateTimeImmutable;
use Mangati\Sicoob\Dto\AuthenticationToken;
use Mangati\Sicoob\Dto\CobrancaBancaria\IncluirBoletosRequest;
use Mangati\Sicoob\Model\CobrancaBancaria\Boleto;
use Mangati\Sicoob\Model\CobrancaBancaria\Pagador;
use Mangati\Sicoob\SicoobCobrancaBancariaClient;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

/**
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
class SicoobBoletoTest extends TestCase
{
    private const CLIENT_ID = 'testClientId';

    public function testIncluirBoletos(): void
    {
        $token = new AuthenticationToken(
            clientId: self::CLIENT_ID,
            accessToken: '123',
            tokenType: 'Bearer',
            expiresIn: 1,
            refreshExpiresIn: 1,
            scopes: [],
        );

        $client = new MockHttpClient([
            function ($method, $url, $options): MockResponse {
                $expectedUrl = 'https://api.sicoob.com.br/cobranca-bancaria/v3/boletos';
                $expectedBody = TestUtils::readResource('incluir-boletos-request.json');

                $this->assertSame('POST', $method);
                $this->assertSame($expectedUrl, $url);
                $this->assertJsonStringEqualsJsonString($expectedBody, $options['body']);

                return new MockResponse(
                    TestUtils::readResource('incluir-boletos-response.json'),
                    [ 'http_code' => 200 ]
                );
            },
        ]);

        $sicoob = new SicoobCobrancaBancariaClient($client);

        $response = $sicoob->incluirBoletos($token, new IncluirBoletosRequest(
            boleto: $this->buildBoleto(),
        ));

        $this->assertInstanceOf(Boleto::class, $response->resultado);
        $this->assertSame(999999, $response->resultado->numeroCliente);
    }

    public function testIncluirBoletosSandboxUrl(): void
    {
        $client = new MockHttpClient([
            function ($method, $url, $options): MockResponse {
                $expectedUrl = 'https://sandbox.sicoob.com.br/sicoob/sandbox/cobranca-bancaria/v3/boletos';

                $this->assertSame('POST', $method);
                $this->assertSame($expectedUrl, $url);

                return new MockResponse(
                    TestUtils::readResource('incluir-boletos-response.json'),
                    [ 'http_code' => 200 ]
                );
            },
        ]);

        $token = SicoobCobrancaBancariaClient::sandboxToken();
        $sicoob = new SicoobCobrancaBancariaClient($client);

        $sicoob->incluirBoletos($token, new IncluirBoletosRequest(
            boleto: $this->buildBoleto(),
        ));
    }

    private function buildBoleto(): Boleto
    {
        return new Boleto(
            numeroCliente: 999999,
            codigoModalidade: 1,
            numeroContaCorrente: 123456,
            codigoEspecieDocumento: "FAT",
            dataEmissao: DateTimeImmutable::createFromFormat('!Y-m-d', '2022-08-15'),
            seuNumero: "158",
            identificacaoEmissaoBoleto: 2,
            identificacaoDistribuicaoBoleto: 2,
            valor: 150.00,
            dataVencimento: DateTimeImmutable::createFromFormat('!Y-m-d', '2022-08-22'),
            dataMulta: DateTimeImmutable::createFromFormat('!Y-m-d', '2022-08-23'),
            dataJurosMora: DateTimeImmutable::createFromFormat('!Y-m-d', '2022-08-23'),
            tipoDesconto: 0,
            tipoMulta: 2,
            valorMulta: 5.00,
            tipoJurosMora: 2,
            valorJurosMora: 2.00,
            numeroParcela: 1,
            pagador: new Pagador(
                numeroCpfCnpj: "12345678901234",
                nome: "Nome do Pagador",
                endereco: "Av. Teste, 1000",
                bairro: "Bairro Teste",
                cidade: "Cidade Teste",
                cep: "12345678",
                uf: "TT",
                email: "email@test.com"
            ),
            gerarPdf: true,
        );
    }
}
